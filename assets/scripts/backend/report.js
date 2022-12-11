/**
 * Settings scripts
 *
 * @since v1.0.0
 */

const { __ } = wp.i18n;
window.addEventListener("DOMContentLoaded", function () {
	const reportForm = document.getElementById("ep-report-form");
	if (reportForm) {
		reportForm.onsubmit = async (e) => {
			e.preventDefault();
			const formData = new FormData(reportForm);
			const paramObj = {
				"poll-id": formData.get("poll-id"),
				"report-type": formData.get("ep-report-type"),
			};
			window.location = urlPrams(paramObj);
		};
	}

	/**
	 * Set URL params
	 *
	 * @param {*} paramObj key & value pair of paramObj
	 * For ex: {id: 2, name: 'abc'}
	 *
	 * @returns string new URL
	 */
	function urlPrams(paramObj) {
		const url = new URL(window.location.href);
		const params = url.searchParams;
		for (let [k, v] of Object.entries(paramObj)) {
			params.set(k, v);
		}
		params.set("paged", 1);
		return url;
	}
});
