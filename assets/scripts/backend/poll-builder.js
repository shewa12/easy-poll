/**
 * Poll field single/multiple choice, input/text area
 * form submit handler.
 *
 * @since v1.0.0
 */

import addDynamicField from "../utilities/add-remove";
import ajaxRequest from "../utilities/ajax-request";
import manageResponse from "../utilities/manage-response";

const { __ } = wp.i18n;

// Handle single/multiple choice question
const saveButtons = document.querySelectorAll(".ep-choice-question-save");
saveButtons.forEach((button) => {
	button.onclick = async (event) => {
		event.preventDefault();
		const formData = new FormData(event.target.closest("form"));
		const response = await ajaxRequest(formData, true, event.target);
		const notifyElem = "#ep-single-multiple-snackbar";
		console.log(response.data);
		// If operation success then reset form.
		if (response.success) {
			event.target.closest("form").reset();

			// Append inserted question on the builder
            const {field_id, field_label, field_type} = response.data.field;
            const {options} = response.data;
			const holder = ".ep-poll-fields-wrapper";
            let optionsHtml = '<div class="ep-field-options-wrapper ep-ml-30">';
            optionsHtml += '<div>';

            options.forEach(item => {
                optionsHtml += `
                <div class="ep-field-options d-flex">
                    <ul>
                        <li>
                            ${item.option_label}
                        </li>
                    </ul>
                </div>
                `;
            });
			const htmlElem = `
                <div class="ep-remove-able-wrapper">
                    <div class="ep-row ep-justify-between ep-mt-20">
                        <div class="ep-form-group ep-col-10 ep-d-flex ep-gap-10 ep-justify-between" data-serial="1">
                            <strong data-field-id="${field_id}">
                                ${field_label} (${field_type})
                            </strong>
                        </div>
                        <div class="ep-form-group ep-d-flex ep-gap-10">
                            <button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-field-delete" data-field-id="${field_id}" data-warning="Do you want to delete this question?">
                                ${__("Delete", "easy-poll")}
                            </button>
                        </div>
                    </div>
                    ${optionsHtml}
                </div>
            `;
            addDynamicField(htmlElem, holder);
		}

		// If it is save & close button then close the modal.
		if (button.classList.contains("ep-save-and-close")) {
			const modal = event.target.closest(".ep-modal-wrapper");
			if (modal && modal.classList.contains("opened")) {
				modal.classList.remove("opened");
			}
		} else {
			const successMsg = __(
				"Question created success fully",
				"easy-poll"
			);
			const failMsg = response.data;
			manageResponse(response, notifyElem, successMsg, failMsg);
		}
	};
});

// Handle input/textarea type question
const inputTextareaSaveButton = document.querySelector(
	".ep-input-textarea-question-save"
);
if (inputTextareaSaveButton) {
	inputTextareaSaveButton.onclick = async (event) => {
		event.preventDefault();
		const formData = new FormData(event.target.closest("form"));
		const response = await ajaxRequest(formData, true, event.target);
		const notifyElem = "#ep-input-textarea-snackbar";

		// If operation success then reset form.
		if (response.success) {
			event.target.closest("form").reset();
            // Append question
            const holder = ".ep-poll-fields-wrapper";
            let htmlElem = '';
            response.data.forEach(item => {
                htmlElem += `
                <div class="ep-remove-able-wrapper">
                    <div class="ep-row ep-justify-between ep-mt-20">
                        <div class="ep-form-group ep-col-10 ep-d-flex ep-gap-10 ep-justify-between" data-serial="1">
                            <strong data-field-id="${item.poll_id}">
                                ${item.field_label} (${item.field_type})
                            </strong>
                        </div>
                        <div class="ep-form-group ep-d-flex ep-gap-10">
                            <button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-field-delete" data-field-label="${item.field_label}" data-warning="Do you want to delete this question?">
                                ${__("Delete", "easy-poll")}
                            </button>
                        </div>
                    </div>
                </div>
                `;
            });
 
            addDynamicField(htmlElem, holder);
		}
		const successMsg = __("Question created success fully", "easy-poll");
		const failMsg = __(
			"Question created failed! Please try again",
			"easy-poll"
		);
		manageResponse(response, notifyElem, successMsg, failMsg);
	};
}
