var coconutsToAdd = 0


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function addCoconutsToDB() {
    await fetch(`add-coconuts.php?coconuts=${coconutsToAdd}`)
    console.log(`add-coconuts.php?coconuts=${coconutsToAdd}`)
    console.log('added')
    console.log(coconutsToAdd)
    coconutsToAdd = 0
}

function addCoconuts(newCoconuts) {
    coconutsToAdd += newCoconuts
    coconuts += newCoconuts
    document.getElementById('coconut-counter').innerText = 'Coconuts: ' + coconuts
}

const updateCoconuts = setInterval(addCoconutsToDB, 10000)

async function animateCoconut() {
    const coconut = document.getElementById('coconut')
    coconut.classList.add('clicked')
    await sleep(100);
    coconut.classList.remove('clicked')
}

