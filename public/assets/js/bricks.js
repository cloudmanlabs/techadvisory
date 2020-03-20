// Timeout cause otherwise the steps thingy messes it up
setTimeout(() => {
    setUp()
    updateTotals()
}, 3000);

function setUp() {
    var simpleList = document.getElementById("simpleList");
    var fitgapBricks = document.getElementById('fitgapBricks')
    var vendorBricks = document.getElementById('vendorBricks')
    var experienceBricks = document.getElementById('experienceBricks')
    var innovationBricks = document.getElementById('innovationBricks')
    var implementationBricks = document.getElementById('implementationBricks')

    sortable = new Sortable(simpleList, {
        group: {
            name: 'shared',
        },
        animation: 150,
        ghostClass: "sortable-ghost",
        onEnd: function () {
            updateTotals()
        }
    });

    sortableFitgap = new Sortable(fitgapBricks, {
        group: {
            name: 'shared',
        },
        animation: 150,
        ghostClass: "sortable-ghost",
        onEnd: function () {
            updateTotals()
        }
    });

    sortableVendor = new Sortable(vendorBricks, {
        group: {
            name: 'shared',
        },
        animation: 150,
        ghostClass: "sortable-ghost",
        onEnd: function () {
            updateTotals()
        }
    });

    sortableExperience = new Sortable(experienceBricks, {
        group: {
            name: 'shared',
        },
        animation: 150,
        ghostClass: "sortable-ghost",
        onEnd: function () {
            updateTotals()
        }
    });

    sortableInnovation = new Sortable(innovationBricks, {
        group: {
            name: 'shared',
        },
        animation: 150,
        ghostClass: "sortable-ghost",
        onEnd: function () {
            updateTotals()
        }
    });

    sortableImplementation = new Sortable(implementationBricks, {
        group: {
            name: 'shared',
        },
        animation: 150,
        ghostClass: "sortable-ghost",
        onEnd: function () {
            updateTotals()
        }
    });
}

function updateTotals() {
    var simpleList = document.getElementById("simpleList");
    var fitgapBricks = document.getElementById('fitgapBricks')
    var vendorBricks = document.getElementById('vendorBricks')
    var experienceBricks = document.getElementById('experienceBricks')
    var innovationBricks = document.getElementById('innovationBricks')
    var implementationBricks = document.getElementById('implementationBricks')

    document.getElementById('fitgapTotal').innerHTML = (fitgapBricks.childElementCount * 5) + '%';
    document.getElementById('vendorTotal').innerHTML = (vendorBricks.childElementCount * 5) + '%';
    document.getElementById('experienceTotal').innerHTML = (experienceBricks.childElementCount * 5) + '%';
    document.getElementById('innovationTotal').innerHTML = (innovationBricks.childElementCount * 5) + '%';
    document.getElementById('implementationTotal').innerHTML = (implementationBricks.childElementCount * 5) + '%';
}
