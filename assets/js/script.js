window.App = new Object();

App.columns = {
    "todo": document.getElementById("todo"),
    "doing": document.getElementById("doing"),
    "test": document.getElementById("test"),
    "done": document.getElementById("done")
};

App.card_colors  = {
    'todo': 'blue lighten-5',
    'doing': 'orange lighten-3',
    'test': 'green lighten-4',
    'done': 'grey lighten-5'
};

App.text = {
    work_time : " Затраченное время ",
    task_is_delegated : " ДЕЛИГИРОВАННАЯ ЗАДАЧА "
}

App.current_task = 0;
App.current_task_status = "";
App.last_task_id = 0;
App.final_status = "done";

App.ui = {
    buttons: {
        save_task_btn: document.getElementById("save-task-btn"),
        new_task_btn: document.getElementById("new-task-btn"),
        task_menu_btn: document.getElementById("task-menu-btn"),
        task_modal_close_btn: document.getElementById("task-modal-close-btn"),
        show_del_alert_btn: document.getElementById("delete-task-btn"),
        del_confirm_btn: document.getElementById("delete-confirm-btn")
    },
    menu: {
        task_menu: document.getElementById("task-menu")
    },
    fields: {
        task_name: document.getElementById("task-name"),
        task_text: document.getElementById("task-text"),
        task_date: document.getElementById("task-date"),
        task_time: document.getElementById("task-time")
    },
    labels: {
        task_window_header: document.getElementById("task-window-header")
    },
    checkboxes: {
        tags_checkbox: ".task-tags"
    }

};


App.timer = 1000*60*5; //проверка просроченных задач каждые 5 минут
App.delay_decoration = "line-through";


App.tags_binding = {
    'tag-urgently' : '<span class="new badge red" data-badge-caption="Срочно"></span>',
    'tag-important' : '<span class="new badge orange" data-badge-caption="Важно"></span>',
    'tag-agreed' : '<span class="new badge green" data-badge-caption="Согласованно"></span>',
    'tag-approve' : '<span class="new badge cyan accent-4" data-badge-caption="Согласовать"></span>',
    'tag-await' : '<span class="new badge gray" data-badge-caption="Ожидает"></span>',
    'tag-finalize' : '<span class="new badge blue" data-badge-caption="Доработать"></span>',
    'tag-idea' : '<span class="new badge light-blue darken-3" data-badge-caption="Идея"></span>',
    'tag-shared' : '<span class="" style="display:table" title="Задача назначена Вам"><i class="material-icons small deep-orange-text">share</i></span>'
};


document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    loadTasks();

    var editor = new MediumEditor('.editable', {
        placeholder:{text:''},
        disableDoubleReturn:true,
        relativeContainer:"relative",
        toolbar: { buttons: ['bold', 'italic', 'strikethrough', 'underline','h2', 'h3', 'quote'] }
    });

    App.ui.buttons.show_del_alert_btn.addEventListener("click", showDeleteDialog);
    App.ui.buttons.del_confirm_btn.addEventListener("click", deleteTask);
    App.ui.buttons.save_task_btn.addEventListener("click", updateTaskDetails);
    App.ui.buttons.new_task_btn.addEventListener("click", newTask);


    setInterval(() => checkDeadline(), App.timer);

    i18n = new Object();
    i18n.months =  ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
    i18n.monthsShort = ['Янв','Фев','Март','Апр','Май','Июнь','Июль','Авг','Сент','Окт','Ноя','Дек'];
    i18n.weekdaysShort= ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'];
    i18n.weekdaysAbbrev= ['В','П','В','С','Ч','П','С'];
    let dateMin = new Date(2023,0,1,0,0,0,0);
    let dateMax = new Date(2050,0,1,0,0,0,0);
    //let defDate = new Date(1993,9,20,0,0,0,0);
    let yRange = [2023,2050];

    var date_elems = document.querySelectorAll('.datepicker');
    var dt_picker = M.Datepicker.init(date_elems, {autoClose:true,format:"dd.mm.yyyy",
        disableWeekends:false,  yearRange:20,firstDay:1,
        isRTL:false, minDate:dateMin, maxDate:dateMax, yearRange:yRange,
        defaultDate:new Date(),i18n, container:"body" });

    var time_elems = document.querySelectorAll('.timepicker');
    var tm_picker = M.Timepicker.init(time_elems, {autoClose:true,twelveHour:false,
        defaultTime:"10:00", container:"body" });

    var modal_elems = document.querySelectorAll('.modal');
    var modal_instance = M.Modal.init(modal_elems, {dismissible:false, preventScrolling:true});


    var drake =  dragula([
            App.columns["todo"],
            App.columns["doing"],
            App.columns["test"],
            App.columns["done"]
        ],
        {revertOnSpill: true}
    );


    drake.on('drop', function(el, target, source, sibling) {
        var elements = Array.from(target.children);
        var elementsOrder = new Object();
        elements.forEach(function (element, key) {
            elementsOrder[element.id] = key;
        });
        let order = JSON.stringify(elementsOrder);

        if (source.id == 'done') {
            drake.cancel();
            M.toast({html: 'Задача уже завершена!', classes: 'red'});
            return false;
        }

        let id = "card-" + el.id;
        let element = document.getElementById(id);
        switch (target.id) {
            case "todo":
                element.setAttribute("class","card " + App.card_colors['todo']);
                break;
            case "doing":
                element.setAttribute("class","card " + App.card_colors['doing']);
                break;
            case "test":
                element.setAttribute("class","card " + App.card_colors['test']);
                break;
            case "done":
                element.setAttribute("class","card " + App.card_colors['done']);
                let tags_id = "card-summary-" + el.id;
                let tags = document.getElementById(tags_id);
                tags.innerHTML = '';
                break;
        }

        //передаю изменения сортировки
        request("https://doska.dev/doska-v1/setState?taskId="+el.id+"&state="+target.id+"&elements="+order, "", (ok) => {M.toast({html: 'Готово!', classes: 'green'});} , (e) => {console.log(e)} );

    });

});


function checkDeadline(notify = true) {
    var containerIds = ["todo", "doing", "test"];
    var result = Math.floor(Date.now() / 1000);
    var counter = 0;

    containerIds.forEach(function (containerId) {
        var elems = document.getElementById(containerId).querySelectorAll('.card-deadline');
        elems.forEach(function (elem) {
            let block = document.getElementById(elem.id);
            if (stringToTimestamp(elem.innerText) < result && block.style.textDecoration != App.delay_decoration) {
                block.style.textDecoration = App.delay_decoration;
                counter++;
            }
        });
    });

    if (counter > 0 && notify) {
        showNotify("Упс","А ты не все успеваешь вовремя(");
    }
}


function createTaskCardBlock(id, color, name, dl, tags, status) {
    function makeElem(type, id, css, inner) {
        var elem = document.createElement(type);
        if (css.length > 0) elem.className = css;
        if (inner.length > 0) elem.innerHTML = inner;
        if (parseInt(id) > 0 || id.length > 0) elem.id = id;
        return elem;
    }

    let row = makeElem('div', id, 'row task','');
    let col = makeElem('div','','col s12 m12','');
    let card = makeElem('div', 'card-' + id,'card ' + color, '');
    let content = makeElem('div','','card-content', '');
    let title = makeElem('div','card-title-' + id,'card-title', name);
    let summary = makeElem('div','card-summary-' + id, 'card-summary', tags);
    let deadline = makeElem('div','card-deadline-' + id, 'card-deadline', dl);


    if (stringToTimestamp(dl) < Math.floor(Date.now() / 1000) && status != App.final_status) {
        deadline.style.textDecoration = App.delay_decoration;
    }

    content.appendChild(title);
    content.appendChild(summary);
    content.appendChild(deadline);
    card.appendChild(content);
    col.appendChild(card);
    row.appendChild(col);

    return row;
}


function getTagsFromTask(task) {
    let tags = '';
    if (task.tags.length > 0) {
        let tags_ar = task.tags.split(';');
        tags_ar.forEach(function (tag) {
            tags += App.tags_binding[tag];
        });
    }

    //add mark if you is not owner of this task
    //if (task.role == 'executor') {
    //    tags += App.tags_binding['tag-shared'];
   // }

    return tags;
}


function getTaskCard(task) {
    var block;
    let timestamp = stringDatefromMillis(task.deadline) + " " + stringTimefromMillis(task.deadline);
    let tags = getTagsFromTask(task);
    block = createTaskCardBlock(task.id, App.card_colors[task.status], task.name, timestamp, tags, task.status);
    block.addEventListener("click", (evt) => {
        loadTaskDetails(task.id);
    });
    return block;
}

function appendTask(task) {
    App.columns[task.status].appendChild(getTaskCard(task));
}

function replaceTask(current_task_id, new_task) {
    let current_card = document.getElementById(current_task_id);
    let new_card = getTaskCard(new_task);
    current_card.replaceWith(new_card);
}

function stringDatefromMillis(date) {
    const today = new Date(date * 1000);
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();
    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;
    return dd + '.' + mm + '.' + yyyy;
}

function stringTimefromMillis(date) {
    var today = new Date(date * 1000);
    let hours  = today.getHours();
    if (hours < 10) hours = '0' + hours;
    let mins = "0" + today.getMinutes();
    return hours + ':' + mins.substr(-2);
}

function stringToTimestamp(str) {
    // Проверяем, если строка пуста или состоит только из пробелов, возвращаем текущую метку времени
    if (!str.trim()) {
        let result = Date.now();
        return Math.floor(result/1000)+60*60*24;
    }

    var dateParts = str.split(" "); // Разделяем строку на дату и время

    var date = dateParts[0].split(".");
    var time = dateParts[1].split(":");

    // Создаем объект Date и возвращаем метку времени
    var timestamp = new Date(date[2], date[1] - 1, date[0], time[0], time[1]).getTime()/1000;

    // Проверяем, если метка времени является недействительной, возвращаем текущую метку времени
    if (isNaN(timestamp)) {
        let result = Date.now();
        return Math.floor(result/1000)+60*60*24;
    }

    return timestamp;
}

function getHHMMfromHours(decimalTime) {
    // Извлекаем целую часть часов
    const hours = Math.floor(decimalTime);

    // Вычисляем минуты, умножив дробную часть на 60
    const minutes = Math.round((decimalTime - hours) * 60);

    // Форматируем часы и минуты в строку
    const formattedHours = String(hours).padStart(2, '0');
    const formattedMinutes = String(minutes).padStart(2, '0');

    // Возвращаем строку формата "часы:минуты"
    return `${formattedHours}:${formattedMinutes}`;
}

function loadTasks() {
    let postData = {
        lastId: App.last_task_id
    };

    postRequest('https://doska.dev/doska-v1/getAll', JSON.stringify(postData),
        function(response) {
            tasks = JSON.parse(response);
            tasks.forEach(function (task) {

                if (App.last_task_id < task.id) {
                    App.last_task_id = task.id
                }
                appendTask(task);
            });
        },
        function(error) {
            console.error('Error:', error);
        }
    );

}

function loadTaskDetails(task_id) {
    let postData = {
        taskId: task_id
    };

    postRequest('https://doska.dev/doska-v1/getTask', JSON.stringify(postData),
        function(response) {
            showTaskDetails(response)

        },
        function(error) {
            console.error('Error:', error);
        }
    );
}


function clearTaskWindow() {
    App.ui.fields.task_name.value = "";
    App.ui.fields.task_text.innerHTML = "";
    App.ui.fields.task_date.value = "";
    App.ui.fields.task_time.value = "";
    App.ui.menu.task_menu.style.display = "block";
    App.ui.buttons.task_menu_btn.display = "initial";
    App.ui.buttons.save_task_btn.style.display = "initial";
    App.ui.buttons.new_task_btn.style.display = "initial";
    App.ui.fields.task_date.disabled = false;
    App.ui.fields.task_time.disabled = false;
    App.ui.fields.task_name.disabled = false;

    let tags_elems = document.querySelectorAll(App.ui.checkboxes.tags_checkbox);
    tags_elems.forEach(function (elem) {
        if (elem.checked)  {
            elem.checked = false;
        }
    });
}
function showAddTaskWindow() {
    var instance = M.Modal.getInstance(document.getElementById("modal1"));
    clearTaskWindow();
    App.ui.buttons.save_task_btn.style.display = "none";
    App.ui.menu.task_menu.style.display = "none";
    instance.open();
}

function showTaskDetails(data) {
    clearTaskWindow();
    App.ui.buttons.new_task_btn.style.display = "none";
    let taskObj = JSON.parse(data)[0];
    App.current_task = taskObj.id;
    App.current_task_status = taskObj.status;
    App.ui.fields.task_name.value = taskObj.name;
    App.ui.fields.task_text.innerHTML = taskObj.comment;
    App.ui.fields.task_date.value = stringDatefromMillis(taskObj.deadline);
    App.ui.fields.task_time.value = stringTimefromMillis(taskObj.deadline);
    let header = "";
/*    if (taskObj.role != "owner") {
        header = App.text.task_is_delegated;
        App.ui.buttons.task_menu_btn.style.display = "none";
    }*/
    App.ui.labels.task_window_header.innerText = App.text.work_time + getHHMMfromHours(taskObj.works_time) + header;

    //поставить теги
    setChecked(App.ui.checkboxes.tags_checkbox, taskObj.tags);
/*    if (taskObj.role != "owner") {
        App.ui.fields.task_date.disabled = true;
        App.ui.fields.task_time.disabled = true;
        App.ui.fields.task_name.disabled = true;
    }*/

    if (taskObj.status == "done") {
        App.ui.buttons.save_task_btn.style.display = "none";
    }

    M.Modal.getInstance(document.getElementById("modal1")).open();
}


function showDeleteDialog() {
    M.Modal.getInstance(document.getElementById("modal1")).close();
    M.Modal.getInstance(document.getElementById("alert-modal")).open();
}

function deleteTask() {
    var task = {
        id: App.current_task,
    };

    //request
    let task_elem = document.getElementById(task.id);
    request("https://doska.dev/doska-v1/deleteTask?taskId="+task.id, "",
        (ok) => {
            M.toast({html: 'Задача удалена!', classes: 'green'});
            task_elem.remove();
        } ,
        (e) => {
            M.toast({html: 'Ошибка удаления задачи', classes:'red'});
        }
    );

    App.current_task = 0;
    M.Modal.getInstance(document.getElementById("alert-modal")).close();
}

function getChecked(elem) {
    let tags_elems = document.querySelectorAll(elem);
    let tags = [];
    tags_elems.forEach(function (elem) {
        if (elem.checked)  {
            tags.push(elem.value);
        }
    });
    return tags;
}


function setChecked(elem, task_tags) {
    let tags_elems = document.querySelectorAll(elem);
    tags_elems.forEach(function (elem) {
        if (task_tags.includes(elem.value))  {
            elem.checked = true;
        }
    });
}

function updateTaskDetails() {

    tags = getChecked(App.ui.checkboxes.tags_checkbox);

    var task = {
        id: App.current_task,
        name: App.ui.fields.task_name.value,
        text: App.ui.fields.task_text.innerHTML,
        status: App.current_task_status,
        tags: tags,
        deadline:  App.ui.fields.task_date.value + " " + App.ui.fields.task_time.value
    };

    if (task.name < 2) {
        M.toast({html: 'Нельзя сохранить задачу без названия!', classes:'red'});
        return false;
    } else {

        var instance = M.Modal.getInstance(document.getElementById("modal1"));

        if (instance.isOpen) { instance.close() }

        postRequest('https://doska.dev/doska-v1/updateTask', JSON.stringify(task),
            function(response) {
                M.toast({html: 'Задача обновлена', classes:'green'});

                // обновление карточки задачи
                let data = {taskId: task.id};
                postRequest('https://doska.dev/doska-v1/getOne', JSON.stringify(data),
                    function(response) {
                        let updated_task = JSON.parse(response)[0];
                        replaceTask(task.id, updated_task);
                    },
                    function(error) {
                        M.toast({html: 'Ошибка загрузки задачи', classes:'red'});
                    }
                );
            },
            function(error) {
                M.toast({html: 'Ошибка обновления задачи', classes:'red'});
            }
        );
        App.current_task = 0;
        App.current_task_status = "";
    }
}

function newTask() {

    var task = {
        id: 0,
        name: App.ui.fields.task_name.value,
        text: App.ui.fields.task_text.innerHTML,
        status: "todo",
        tags: getChecked(App.ui.checkboxes.tags_checkbox),
        deadline: stringToTimestamp(App.ui.fields.task_date.value + " " + App.ui.fields.task_time.value)
    };


    var instance = M.Modal.getInstance(document.getElementById("modal1"));

    if (task.name < 2) {
        M.toast({html: 'Нельзя создать задачу без названия!', classes:'red'});
        return false;
    } else {

        if (instance.isOpen) { instance.close() }

        postRequest('https://doska.dev/doska-v1/newTask', JSON.stringify(task),
            function(response) {
                M.toast({html: 'Задача создана', classes:'green'});
                App.last_task_id = response;
                loadTasks();
            },
            function(error) {
                M.toast({html: 'Ошибка создания задачи ' + error, classes:'red'});
            }
        );
    }

}

function request (url, data, okFunc, errFunc) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url + data,'true');
    xhr.send();

    xhr.onload = function() {
        if (xhr.status != 200) {
            //console.log(xhr.status, xhr.statusText);
            errFunc(xhr.statusText);
        } else {
            //console.log("request ok");
            okFunc(xhr.response);
        }
    };

    xhr.onerror = function() {
        //console.log("request error");
        errFunc(xhr.status);
    };

    xhr.onprogress = function(event) {
        if (event.lengthComputable) {
            //console.log(`Получено ${event.loaded} из ${event.total} байт`);
        } else {
            //console.log(`Получено ${event.loaded} байт`);
        }
    };
}

function postRequest(url, data, okFunc, errFunc) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            okFunc(xhr.responseText);
        } else {
            errFunc(xhr.statusText);
        }
    };

    xhr.onerror = function() {
        errFunc(xhr.status);
    };

    xhr.send(data);
}