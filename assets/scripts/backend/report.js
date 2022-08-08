/**
 * Settings scripts
 *
 * @since v1.0.0
 */

import ajaxRequest from "../utilities/ajax-request";

const { __ } = wp.i18n;
window.addEventListener("DOMContentLoaded", function () {
	const reportForm = document.getElementById("ep-report-form");
	if (reportForm) {
		reportForm.onsubmit = async (e) => {
			e.preventDefault();
			const formData = new FormData(reportForm);
			window.location = urlPrams("poll-id", formData.get("poll-id"));
		};
	}

	function urlPrams(type, val) {
		const url = new URL(window.location.href);
		const params = url.searchParams;
		params.set(type, val);
		params.set("paged", 1);
		return url;
	}
});
