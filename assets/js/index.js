let category = document.querySelectorAll('.category');
let task = document.querySelectorAll('.task');
let labels = document.querySelectorAll('.label');
let td_labels = document.querySelectorAll('.labels');


let side_category = document.querySelectorAll('.side_category');
let side_task = document.querySelectorAll('.side_task');
let side_label = document.querySelectorAll('.side_label');

let items = [...side_category, ...side_task, ...side_label];

for (i of items){
    i.addEventListener('click', function(e){
        children = this.closest('.level').querySelectorAll('.level .option input');

        for (child of children){
            child.checked = this.checked;
        }
        
        clickfilter();
    });
}



function clickfilter() {
    lines = document.querySelectorAll('.category');
    for(line of lines){
        line.closest('tr').style.display = 'table-row';
    }
    for(cell of category) {
        if(!(
            (() => {
            tag = true;
            for(side of side_category){
                if(side.checked) {
                    if (cell.innerHTML == side.closest('.option').querySelector('label').innerHTML) {
                        return true;
                    }
                    tag = false;
                }
            }
            return (tag) ? true : false;
            })()
        )) {
            cell.closest('tr').style.display = 'none';
        }
    }

    for(cell of task) {
        if(!(
            (() => {
            tag = true;
            for(side of side_task){
                if(side.checked) {
                    
                    if (cell.innerHTML == side.closest('.option').querySelector('label').innerHTML) {
                        return true;
                    }
                    tag = false;
                }
            }
            return (tag) ? true : false;
            })()
        )) {
            cell.closest('tr').style.display = 'none';
        }
    }

    for(cells of td_labels){
        if (!(
            (() => {
                tag = true;
                for(side of side_label){
                    if(side.checked) {
                        for(cell of cells.querySelectorAll('.label')){
                            if(cell.innerHTML == side.closest('.option').querySelector('label').innerHTML) {
                                return true;
                            }
                        }
                        tag = false;
                    }
                }
                return (tag) ? true : false;
            })()
        )) {
            tl.closest('tr').style.display = 'none';
        }
        
    }
}



for(ct of category) {
    ct.addEventListener('click', function(e) {
        for(sc of side_category) {
            sc.checked = false;
            if(sc.closest('.option').querySelector('label').innerHTML == this.innerHTML) {
                sc.click();
            }
        }
        clickfilter();
    });
}

sbars = document.querySelectorAll('.sbar');
sbars.forEach((s) => {
    s.addEventListener('click', function(e) {
        content = this.closest('.wrap-sbar').querySelector('.wrap-sbar-content');
        if(content.style.display == 'block') {
            content.style.display = 'none';
        } else { content.style.display = 'block'; }
    });
});

sbar2s = document.querySelectorAll('.sbar2'); //
sbar2s.forEach((s) => {
    s.addEventListener('click', function(e) {
        content = this.closest('.wrap-sbar2').querySelector('.wrap-options');
        if(content.style.display == 'block') {
            content.style.display = 'none';
        } else { content.style.display = 'block'; }
    });
});