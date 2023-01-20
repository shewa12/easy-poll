document.addEventListener('DOMContentLoaded', async function() {
    const defaultErrorMsg = 'Something went wrong, please refresh the page';
    const ctx = document.getElementById("ep-active-polls-chart");
    const formData = new FormData();
    formData.set(epData.nonce_action, epData.nonce);
    formData.set('action', 'ep_get_active_polls_report');

    // Show loading message
    const loadingWrapper = document.getElementById('ep-loading-msg');
    loadingWrapper.innerHTML = 'Generating report...';

    const post = await fetch(epData.url, {
        method: 'POST',
        body: formData,
    });

    loadingWrapper.innerHTML = '';

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
                            label: "Polls",
                            data: votes,
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    barThickness: 50,
                    scales: {
                        y: {

                            beginAtZero: true
                        },
                        x: {
                            ticks:{
                                callback: function(i) {
                                    let label = labels[i];
                                    if (label.length > 10) {
                                        label = label.substring(0, 12) + '...';
                                    }
                                    return label;
                                }
                            },
                        }
                    }
                }
                
            });
            
        } else {
            alert(data);
        }
    } else {
        alert(defaultErrorMsg)
    }
});