// 表格資料
let category = document.querySelectorAll('.category');
let task = document.querySelectorAll('.task');
let labels = document.querySelectorAll('.label');
let td_labels = document.querySelectorAll('.labels');

// 側邊欄checkbox
let side_category = document.querySelectorAll('.side_category');
let side_task = document.querySelectorAll('.side_task');
let side_label = document.querySelectorAll('.side_label');

let items = [...side_category, ...side_task, ...side_label];

let input_date = document.getElementById('date');

// 當checkbox被按時，篩選資料
for (i of items){
    i.addEventListener('click', function(e){
        children = this.closest('.level').querySelectorAll('.level .option input');

        for (child of children){
            child.checked = this.checked;
        }
        
        clickfilter();
    });
}

// 側邊欄label的or、and被按時，也要篩選資料
for(i of [document.querySelector('#labelor'), document.querySelector('#labeland')]){
    i.addEventListener('click', function(e){
        clickfilter();
    });
}


// 篩選資料
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


// 當按下表格資料時，篩選資料
function resetClickfilter(){
    category = document.querySelectorAll('.category');

    task = document.querySelectorAll('.task');
    labels = document.querySelectorAll('.label');
    td_labels = document.querySelectorAll('.labels');
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
}
// resetClickfilter();

// 側邊欄收合
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

// 側邊欄排序資料
let sort_by_starttime = document.getElementById('start-time');
let sort_by_endtime = document.getElementById('end-time');
let sort_by_lasttime = document.getElementById('time-lasting');
let sort_by_category = document.getElementById('category');
let sort_by_task = document.getElementById('task');
let plan_tbody = document.getElementById('plan-tbody');
let record_tbody = document.getElementById('record-tbody');
let sort = document.getElementsByClassName('sort');

Array.from(sort).forEach(function(s) {
    s.addEventListener('click', function(e) {
        Array.from(sort).forEach(function(st) {
            st.classList.remove('active');
        });
    });
});

sort_by_starttime.addEventListener('click', (e) => {
    // console.log(record_tbody);
    sortData('start_time');
    sort_by_starttime.classList.add('active');
});
sort_by_endtime.addEventListener('click', (e) => {
    sortData('end_time');
    sort_by_endtime.classList.add('active');
});
sort_by_lasttime.addEventListener('click', (e) => {
    sortData('TIMESTAMPDIFF(second, start_time, end_time)');
    sort_by_lasttime.classList.add('active');
});
sort_by_category.addEventListener('click', (e) => {
    sortData('executiontime_category_id');
    sort_by_category.classList.add('active');
});
sort_by_task.addEventListener('click', (e) => {
    sortData('executiontime_task_id');
    sort_by_task.classList.add('active');
});

Array.from(sort).forEach(function(s) {
    s.addEventListener('click', function(e) {
        setTimeout(function() {
            // resetClickfilter();
        }, 1000);
    });
});

let order = 'end_time DESC';
let date = input_date.value;

function sortData(o){

    plan_tbody.innerHTML = '';
    record_tbody.innerHTML = '';

    order = o;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index_back.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // var responseData = JSON.parse(xhr.responseText);
            var responseData = xhr.responseText.split('|');
            
            plan_tbody.innerHTML = responseData[0];
            record_tbody.innerHTML = responseData[1];
        }
    };
    var formData = "order=" + encodeURIComponent(order) + "&date=" + encodeURIComponent(date);
    xhr.send(formData);
}

// 切換記錄與計畫
record_block = document.getElementById('record-block');
plan_block = document.getElementById('plan-block');

document.getElementById('go-plan').addEventListener('click', (e) => {
    record_block.style.display = 'none';
    plan_block.style.display = 'block';
});

document.getElementById('go-record').addEventListener('click', (e) => {
    record_block.style.display = 'block';
    plan_block.style.display = 'none';
});

//切換日期
document.getElementById('date').addEventListener('change', (e) => {
    plan_tbody.innerHTML = '';
    record_tbody.innerHTML = '';

    date = e.target.value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index_back.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // var responseData = JSON.parse(xhr.responseText);
            var responseData = xhr.responseText.split('|');
            plan_tbody.innerHTML = responseData[0];
            record_tbody.innerHTML = responseData[1];
        }
    };
    var formData = "order=" + encodeURIComponent(order) + "&date=" + encodeURIComponent(date);
    xhr.send(formData);
});

// 點擊表頭時，排序資料
let th_time = document.querySelectorAll('.th-time');
let th_last = document.querySelectorAll('.th-last');
let th_category = document.querySelectorAll('.th-category');
let th_task = document.querySelectorAll('.th-task');

let th_items = [...th_time, ...th_last, ...th_category, ...th_task];

th_items.forEach((item) => {
    item.addEventListener('click', () => {
        sort[0].closest('.wrap-sbar-content').style.display = 'block';
    });
});

th_time.forEach((th) => {
    th.addEventListener('click', () => {
        if(sort_by_starttime.classList.contains('active')) {
            sort_by_endtime.click();
        } else {
            sort_by_starttime.click();
        }
    }, false);
});

th_last.forEach((th) => {
    th.addEventListener('click', () => {
        sort_by_lasttime.click();
    }, false);
});

th_category.forEach((th) => {
    th.addEventListener('click', () => {
        sort_by_category.click();
    }, false);
});

th_task.forEach((th) => {
    th.addEventListener('click', () => {
        sort_by_task.click();
    }, false);
});