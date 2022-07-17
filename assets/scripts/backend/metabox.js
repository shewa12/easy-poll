/**
 * Meta box scripts
 *
 * Add/Remove poll fields
 *
 * @since v1.0.0
 */
import addDynamicField, {removeElement} from "../utilities/add-remove";
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
	const wrapper = document.querySelector(".ep-poll-fields-holder");
	if (wrapper) {
		wrapper.onclick = (event) => {
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
                    ${__('Remove', 'easy-poll')}
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
            <div class="ep-form-group ep-row">
                <button type="button" class="ep-btn ep-btn-danger ep-btn-sm ep-ml-10 ep-remove-able">
                    <i class="dashicons dashicons-remove"></i>
                    ${__('Remove', 'easy-poll')}
                </button>
            </div>
        </div>
         `;
        const fieldsHolder = ".ep-poll-fields-holder";
        //Add dynamic field.
        addDynamicField(html, fieldsHolder);
    }

});
