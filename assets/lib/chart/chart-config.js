document.addEventListener('DOMContentLoaded', async function() {
    const defaultErrorMsg = 'Something went wrong, please refresh the page';
    const ctx = document.getElementById("ep-active-polls-chart");
    const formData = new FormData();
    formData.set(epData.nonce_action, epData.nonce);
    formData.set('action', 'ep_get_active_polls_report');

    const post = await fetch(epData.url, {
        method: 'POST',
        body: formData,
    });
    if (post.ok) {
        const response = await post.json();
        const {success, data} = response;
        
        if (success) {
            const labels = [];
            const votes = [];
            for(poll of data) {
                labels.push(poll.post_title)
                votes.push(poll.total_submission)
            }
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Total Votes: ",
                            data: votes,
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        } else {
            alert(data);
        }
    } else {
        alert(defaultErrorMsg)
    }
});