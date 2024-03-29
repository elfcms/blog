const items = Array.from(document.querySelectorAll('.blog-line-position'));
const lineBoxes = document.querySelectorAll('.blog-nav-line');

let draggedItem = null;
let draggedItemParent = null;

items.forEach(item => {

    if (item.dataset.line != 'blog') {
        let type = item.dataset.line ?? 'element';

        item.addEventListener('dragstart', () => {
            item.classList.add('dragging');
            itemBox = item.parentNode;
            draggedItem = itemBox;
            draggedItemParent = itemBox.parentNode;
        });

        item.addEventListener('dragend', () => {
            draggedItem = null;
            draggedItemParent = null;
            item.classList.remove('dragging');
            itemPositionSuccess(type);
        });
    }

});

const lineContainers = Array.from(document.querySelectorAll('.blog-nav-dnd-area'));

lineContainers.forEach(container => {
    container.addEventListener('dragover', e => {
        e.preventDefault();
        const afterElement = getDragAfterItem(container, e.clientY);
        if (draggedItem) {
            if (container.dataset.container == draggedItem.dataset.line) {
                container.insertBefore(draggedItem, afterElement);
            }
        }
    });
});

function getDragAfterItem(container, y) {
    const draggableElements = Array.from(container.querySelectorAll('.blog-nav-line:not(.dragging)'));

    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;

        if (offset < 0 && offset > closest.offset) {
        return { offset: offset, element: child };
        } else {
        return closest;
        }
    },
    { offset: Number.NEGATIVE_INFINITY }).element;
}

let linesData = {};
let isChanged = false;

function itemPositionSuccess(type) {

    const preLines = Object.assign({}, linesData);

    let changeCount = 0;

    lineContainers.forEach(box => {

        const boxLines = box.querySelectorAll('.blog-nav-line');
        let position = 1;
        if (boxLines) {
            boxLines.forEach(line => {
                if (line.dataset.id) {

                    linesData[line.dataset.id] = {
                        'position': position,
                        'new': false
                    };

                    let isNew = false;

                    if (preLines[line.dataset.id] !== undefined && linesData[line.dataset.id]  !== undefined) {
                        if (preLines[line.dataset.id].position != linesData[line.dataset.id].position) {
                            changeCount++;
                            isNew = true;
                        }
                    }
                    else if (preLines[line.dataset.id] === undefined && linesData[line.dataset.id]  !== undefined) {
                        changeCount++;
                        isNew = true;
                    }

                    linesData[line.dataset.id].new = isNew ? 1 : 0;


                    const positionBox = line.querySelector('.blog-line-position');
                    if (positionBox) {
                        positionBox.innerHTML = position;
                    }
                    position++;
                }
            });
        }
    });

    if (changeCount > 0) {
        isChanged = true;
    }
    else {
        isChanged = false;
    }

    if (isChanged) {
        const data = JSON.stringify({
            lines: linesData,
        });
        const token = document.querySelector("input[name='_token']").value;
        fetch('/elfcms/api/blog/' + type + '/lineorder',{
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token,
            },
            credentials: 'same-origin',
            body: data
        }).then(
            (result) => result.json()
        ).then(data => {
            //
        })
        .catch(error => {
            //
        });
    }

}

