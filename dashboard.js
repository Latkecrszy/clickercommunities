var coconutsToAdd = 0


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function addCoconutsToDB() {
    await fetch(`add-coconuts.php?coconuts=${Math.round(coconutsToAdd)}`)
    console.log(`add-coconuts.php?coconuts=${Math.round(coconutsToAdd)}`)
    console.log('added')
    coconutsToAdd = 0
}

function addCoconuts(newCoconuts) {
    coconutsToAdd += newCoconuts
    coconuts += newCoconuts
    document.getElementById('coconut-counter').innerText = 'Coconuts: ' + Math.round(coconuts)
    /*shop.forEach(e => {
        if (!document.getElementById(e['item_name']).classList.contains('blurred') && parseInt(e['cost']) < coconuts) {

        }
    })*/

}

let updateAutomaticCoconut = setInterval(async () => {
    for (let [key, value] of Object.entries(purchased)) {
        let item = shop[key]
        addCoconuts(parseInt(item['effect'])*parseInt(value['count'])/10)
    }
}, 100)

const updateCoconuts = setInterval(addCoconutsToDB, 10000)

async function animateCoconut() {
    const coconut = document.getElementById('coconut')
    coconut.classList.add('clicked')
    await sleep(100);
    coconut.classList.remove('clicked')
}


async function createCommunity() {
    const name = document.getElementById('create-input-name').value
    const description = document.getElementById('create-input-description').value
    let id = await fetch(`create-community.php?name=${name}&description=${description}`)
        .then(resp => resp.text())
    id = id.split('<body>')[1].split('</body>')[0]
    console.log('gonna replace')
    if (!Number.isNaN(id)) {
        location.replace(`community.php?id=${id}`)
    }
}


async function buyUpgrade(el) {
    if (coconuts < parseInt(el.dataset.cost)) {
        return
    }
    const newCoconuts = 0-parseInt(el.children[2].innerText)
    addCoconuts(newCoconuts)
    await addCoconutsToDB();
    await fetch(`buyupgrade.php?name=${el.dataset.name}&id=${el.dataset.id}&community_id=${el.dataset.community_id}`)
        .then(results => console.log(results.text()))
    el.children[0].innerText = (parseInt(el.children[0].innerText)+1).toString()
    location.reload()
}

