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

for(i of [document.querySelector('#labelor'), document.querySelector('#labeland')]){
    i.addEventListener('click', function(e){
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
                        tag = false;
                        if((document.querySelector('#labelor').checked)) {
                            for(cell of cells.querySelectorAll('.label')){
                                if(cell.innerHTML == side.closest('.option').querySelector('label').innerHTML) {
                                    return true;
                                }
                            }
                        } else {
                            for(cell of cells.querySelectorAll('.label')){
                                if(cell.innerHTML == side.closest('.option').querySelector('label').innerHTML) {
                                    tag = true;
                                }
                            }
                            if (!tag) { return false; }
                        }
                    }
                }
                return (tag) ? true : false;
            })()
        )) {
            cells.closest('tr').style.display = 'none';
        }
        
    }
}



for(td of category) {
    td.addEventListener('click', function(e) {
        // console.log(this);
        for(sideIntdEL of side_category) {
            sideIntdEL.checked = false;
            // console.log(sideIntdEL);
            if(sideIntdEL.closest('.option').querySelector('label').innerHTML == this.innerHTML) {
                // console.log(sideIntdEL, 100);
                sideIntdEL.click();
                sideIntdEL.closest('.wrap-sbar-content').style.display = 'block';
                sideIntdEL.closest('.wrap-options').style.display = 'block';
                // console.log(sideIntdEL, 1);
            }
        }
        clickfilter();
    });
}

for(td of task) {
    td.addEventListener('click', function(e) {
        // console.log(td, 100);
        for(sideIntdEL of side_task) {
            sideIntdEL.checked = false;
            if(sideIntdEL.closest('.option').querySelector('label').innerHTML == this.innerHTML) {
                sideIntdEL.click();
                sideIntdEL.closest('.wrap-sbar-content').style.display = 'block';
                sideIntdEL.closest('.wrap-options').style.display = 'block';
                // console.log(sideIntdEL, 2);
            }
        }
        clickfilter();
    });
}

for(td of labels) {
    td.addEventListener('click', function(e) {
        // console.log(td, 100);
        for(sideIntdEL of side_label) {
            sideIntdEL.checked = false;
            if(sideIntdEL.closest('.option').querySelector('label').innerHTML == this.innerHTML) {
                sideIntdEL.click();
                sideIntdEL.closest('.wrap-sbar-content').style.display = 'block';
                sideIntdEL.closest('.wrap-options').style.display = 'block';
                // console.log(sideIntdEL, 2);
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

var selects = document.querySelectorAll('.sbar2'); //
// console.log(document.querySelector('.sbar'));
// console.log(selects);
selects.forEach((s) => {
    s.addEventListener('click', function(e) {
        content = this.closest('.wrap-sbar2').querySelector('.wrap-options');
        console.log(content);
        if(content.style.display == 'block') {
            content.style.display = 'none';
        } else { content.style.display = 'block'; }
    });
});

order = [];
let sorts = document.querySelectorAll('.sort');
sorts.forEach((s) => {
    
    s.addEventListener('click', function(e) {
        switch(this.id) {
            case 'start-time':
                index = 'start_time';
                break;
            case 'end-time':
                index = 'end_time';
                break;
            case 'time-lasting':
                index = 'DATEDIFF(start_time, end_time)';
                break;
            case 'category':
                index = 'executiontime_category_id';
                break;
            case 'task':
                index = 'executiontime_task_id';
        }
        if (this.classList.contains('active')) {
            this.classList.remove('active');
            i = order.indexOf(index);
            order.splice(i, 1);
        } else {
            this.classList.add('active');
            order.push(index);
        }
        text = 'ORDER BY ';
        order.forEach(function(o){
            text += o + ', ';
        });
        text = text.substring(0, text.length-2);
        window.location.href='index.php?o='+text;
    });
});
