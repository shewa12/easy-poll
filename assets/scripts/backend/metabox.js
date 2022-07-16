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
	const addField = document.querySelector("#ep-field-add-more");
	if (addField) {
		addField.onclick = (event) => {
            addPollField();
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
    function addPollField() {
        const html = `
        <div class="ep-row ep-justify-between ep-pt-10 ep-remove-able-wrapper">
            <div class="ep-form-group ep-col-8">
                <input type="text" id="ep-field-label[]" name="ep-field-label" placeholder="Write field label...">
            </div>
            <div class="ep-form-group ep-row">
                <select name="ep-field-type[]" id="ep-field-type">
                    <option value="" title="Select Field Type">
                        ${__('Select Field Type', 'easy-poll')}							
                    </option>
                    <option value="" title="Single Choice">
                        ${__('Single Choice', 'easy-poll')}							
                    </option>               
                    <option value="" title="Double Choice">
                        ${__('Double Choice', 'easy-poll')}							
                    </option>              
                    <option value="" title="Input Field">
                        ${__('Input Field', 'easy-poll')}							
                    </option>     
                    <option value="" title="Textarea">
                        ${__('Textarea', 'easy-poll')}	
                    </option>
                </select>
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
