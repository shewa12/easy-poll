/**
 * Meta box scripts
 *
 * Add/Remove poll fields
 *
 * @since v1.0.0
 */
import addDynamicField, { removeElement } from "../utilities/add-remove";
import ajaxRequest from "../utilities/ajax-request";
const { __ } = wp.i18n;

document.addEventListener("DOMContentLoaded", function () {
	const addMoreOption = document.querySelector("#ep-add-more-option");
	const addMoreQuestion = document.querySelector("#ep-add-more-question");
	// Add more option field.
	if (addMoreOption) {
		addMoreOption.onclick = (event) => {
			addOptionField();
		};
	}
	// Add more question field
	if (addMoreQuestion) {
		addMoreQuestion.onclick = (event) => {
			addQuestionField();
		};
	}

	// remove element.
	const fieldsWrapper = document.querySelector(".ep-poll-fields-holder");
	const optionsWrapper = document.querySelector(".ep-poll-options-holder");

	// Remove fields.
	if (fieldsWrapper) {
		fieldsWrapper.onclick = (event) => {
			event.preventDefault();
			const target = event.target;
			if (event.target.classList.contains("ep-remove-able")) {
				removeElement(target);
			} else {
				return;
			}
		};
	}

	// Remove options.
	if (optionsWrapper) {
		optionsWrapper.onclick = (event) => {
			event.preventDefault();
			const target = event.target;
			if (event.target.classList.contains("ep-remove-able")) {
				removeElement(target);
			} else {
				return;
			}
		};
	}

	/**
	 * Add poll fields
	 *
	 * It will create poll fields on the html wrapper
	 *
	 * @since v1.0.0
	 */
	function addOptionField() {
		const html = `
        <div class="ep-row ep-justify-between ep-pt-10 ep-remove-able-wrapper">
            <div class="ep-form-group ep-col-8">
                <input type="text" name="ep-field-option[]" placeholder="Write option...">
            </div>
            <div class="ep-form-group ep-row">
                <button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-ml-10 ep-remove-able">
                    <i class="dashicons dashicons-remove"></i>
                    ${__("Remove", "easy-poll")}
                </button>
            </div>
        </div>
         `;
		const fieldsHolder = ".ep-poll-options-holder";
		//Add dynamic field.
		addDynamicField(html, fieldsHolder);
	}

	function addQuestionField() {
		const html = `
        <div class="ep-row ep-justify-between ep-pt-10 ep-remove-able-wrapper">
            <div class="ep-form-group ep-col-8">
                <input type="text" name="ep-field-label[]" placeholder="Write question...">
            </div>
            <div class="ep-form-group">
			    <select name="ep-field-type[]" id="ep-field-type">
                    <option value="input" title="Input Field">
                        ${__('Input Field', 'easy-poll')}
                    </option>
                    <option value="textarea" title="Textarea">
                        ${__('Textarea', 'easy-poll')}
                    </option>
				</select>
		    </div>
            <div class="ep-form-group ep-row">
                <button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-ml-10 ep-remove-able">
                    <i class="dashicons dashicons-remove"></i>
                    ${__("Remove", "easy-poll")}
                </button>
            </div>
        </div>
         `;
		const fieldsHolder = ".ep-poll-fields-holder";
		//Add dynamic field.
		addDynamicField(html, fieldsHolder);
	}

	/**
	 * Event delegation for poll builder meta box
	 * 
	 * It will listen all click event inside poll builder
	 * & will take action as required.
	 *
	 * @since v1.0.0
	 */
	const pollBuilder = document.getElementById('easy-poll-builder');
	const deleteBtn = 'ep-field-delete';
	if (pollBuilder) {
		pollBuilder.onclick = async (event) => {
			const target = event.target;
			if (target.classList.contains(deleteBtn)) {
				const formData = new FormData();
				const fieldId = target.dataset.fieldId;
				const fieldLabel = target.dataset.fieldLabel;
				const warningMsg = target.dataset.warning;
				formData.set(epData.nonce_action, epData.nonce);
				formData.set('action', 'ep_field_delete');
				if (fieldId === undefined) {
					formData.set('field_label', fieldLabel);
				} else {
					formData.set('field_id', fieldId);
				}
				if (confirm(warningMsg)) {
					const response = await ajaxRequest(formData, true, target);
					if (!response.success) {
						if (response.data) {
							alert(response.data);
						}
					} else {
						removeElement(target);
					}
				}
			}
		}
	}
});
