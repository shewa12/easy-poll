const ctx = document.getElementById("ep-active-polls-chart");

new Chart(ctx, {
    type: "bar",
    data: {
        labels: [
            "Election 2022",
            "Blue",
            "Yellow",
            "Green",
            "Purple",
            "Orange",
        ],
        datasets: [
            {
                label: "# of Votes",
                data: [200, 129, 233, 50, 122, 33],
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
