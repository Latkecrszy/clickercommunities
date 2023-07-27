// Create global variable coconutsToAdd to store how many coconuts are to be added
var coconutsToAdd = 0


// Create function to delay program by a given number of milliseconds
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


// Create function to update database with new number of coconuts
async function addCoconutsToDB() {
    // Make request to add-coconuts.php with coconuts to add
    await fetch(`add-coconuts.php?coconuts=${Math.round(coconutsToAdd)}&id=${community_id}`)
    // Reset coconutsToAdd variable
    coconutsToAdd = 0
}


// Create function to update coconutsToAdd variable and update displayed number of coconuts
function addCoconuts(newCoconuts) {
    coconutsToAdd += newCoconuts
    coconuts += newCoconuts
    document.getElementById('coconut-counter').innerText = 'Coconuts: ' + Math.round(coconuts)
}


// Add coconuts produced by upgrades every 100 milliseconds
let updateAutomaticCoconut = setInterval(async () => {
    for (let [key, value] of Object.entries(purchased)) {
        let item = shop[key]
        addCoconuts(parseInt(item['effect'])*parseInt(value['count'])/10)
    }
}, 100)


// Update DB every 10 seconds
const updateCoconuts = setInterval(addCoconutsToDB, 10000)


// Make coconut image wobble when clicked
async function animateCoconut(size='coconut') {
    const coconut = document.getElementById(size)
    coconut.classList.add('clicked')
    await sleep(100);
    coconut.classList.remove('clicked')
}


// Create function to create a new community
async function createCommunity() {
    // Get name and description and exit if either are empty
    const name = document.getElementById('create-input-name').value
    const description = document.getElementById('create-input-description').value
    if (!name || !description) {
        return
    }
    // Send request to create-community.php and store return value as the id of the new community
    let id = await fetch(`create-community.php?name=${name}&description=${description}`)
        .then(resp => resp.text())
    id = id.split('<body>')[1].split('</body>')[0]
    // If the id is valid, redirect to the newly created community
    if (!Number.isNaN(id)) {
        location.replace(`community.php?id=${id}`)
    }
}


// Create function to join a community
async function joinCommunity() {
    // Get community id
    const id = document.getElementById('join-input').value
    // Send request to join-community.php to add a record of the user's membership
    await fetch(`join-community.php?id=${id}`)
    // Redirect to the community
    location.replace(`community.php?id=${id}`)
}


// Create function to buy an upgrade
async function buyUpgrade(el) {
    // Exit if upgrade costs more than the currently owned coconuts
    if (coconuts < parseInt(el.dataset.cost)) {
        return
    }
    // Subtract cost of upgrade from current coconuts
    const newCoconuts = 0-parseInt(el.children[2].innerText)
    addCoconuts(newCoconuts)
    await addCoconutsToDB();
    // Send request to buyupgrade.php to purchase the upgrade
    await fetch(`buyupgrade.php?name=${el.dataset.name}&id=${el.dataset.id}&community_id=${el.dataset.community_id}`)
    // Update number of owned upgrades
    el.children[0].innerText = (parseInt(el.children[0].innerText)+1).toString()
    location.reload()
}

