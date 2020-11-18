<template>
    <div class="content">
        <div class="justify-content-between row ml-1 mr-1 mb-2">
            <div>
                <h3> Dashboard </h3>
            </div>
            <div>
                EMS / Dashboard
            </div>
        </div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                expenses: [],
            }
        },

        mounted() {
            this.loadExpenses();
        },

        methods: {
            loadExpenses() {
                axios.get(`/expenses/${this.$userId}`)
                .then((response) => {
                    var points = [];

                    $.each(response.data, function (key, value) {
                        points.push({
                            y: value.amount, label: value.category
                        });
                    });

                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        title: {
                            text: "Expenses"
                        },
                        data: [{
                            type: "pie",
                            startAngle: 240,
                            yValueFormatString: "Php ##0\"",
                            indexLabel: "{label} {y}",
                            dataPoints: points
                        }]
                    });
                    chart.render();
                })
                .catch(function(error) {
                    console.log(error);
                });
            },

        }
    }
</script>

