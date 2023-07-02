function selectCondition (dep) {
    const depElement = document.querySelector('[data-dep="'+dep+'"]');
    if (depElement) {
        depElement.addEventListener('change',function(){
            const rule = depElement.dataset.rule ?? null;
            if (rule) {
                const condElements = document.querySelector('[data-cond="'+dep+'"]');
                if (condElements) {
                    condElements.forEach(element => {
                        if (element.options) {
                            for (let option of element.options) {
                                if (option.dataset[rule] == depElement.value) {
                                    option.classList.remove('hidden');
                                }
                                else {
                                    option.classList.add('hidden');
                                }
                            }
                        }
                    });
                }
            }
        });
    }
}
