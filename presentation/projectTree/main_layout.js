var myWidth, myHeight, global_skin = 'dhx_terrace', grid_skin = 'dhx_web';
var url = "app/Stream/data.php?action=";


if (typeof (window.innerWidth) == 'number') {

//Non-IE 

    myWidth = window.innerWidth;
    myHeight = window.innerHeight;

} else if (document.documentElement &&
    (document.documentElement.clientWidth || document.documentElement.clientHeight)) {

//IE 6+ in 'standards compliant mode' 

    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;

} else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {

//IE 4 compatible 

    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;

}


dhtmlx.skin = global_skin;

const tutMainPrimary_layout = new dhtmlXLayoutObject({
    parent: document.body,
    pattern: "1C"
});

tutMainPrimary_layout.cells('a').hideHeader();
var profile_toolbar = tutMainPrimary_layout.cells("a").attachMenu();
profile_toolbar.setIconset("awesome");
profile_toolbar.setSkin("material");

if (!projectId) {
    profile_toolbar.loadStruct('<menu>'
        + '<item id="guest">'
        + '<item id="logout" text="Logout"/>'
        + ' </item>'
        + '</menu>', function () {
    });

    profile_toolbar.setItemText("guest", "Welcome :" + username);

}


const tutAdminPrimary = tutMainPrimary_layout.cells("a").attachLayout('2U');

tutAdminPrimary.cells('a').setText('Projects');
tutAdminPrimary.cells('a').setWidth(myWidth * 0.159);


const projectLayout = tutAdminPrimary.cells('b').attachLayout('1C');
projectLayout.cells("a").hideHeader();


const courses_toolbar = tutAdminPrimary.cells('a').attachToolbar();
courses_toolbar.setIconset("awesome");
courses_toolbar.loadStruct('<toolbar>'
    + '<item type="button" id="refresh" text="Refresh" img="fa fa-sync " /><item type="separator" id="sep_1" />'
    + '<item type="button" id="new" text="New Course" img="fa fa-plus " /><item type="separator" id="sep_2" />'
    + '<item type="button" id="delete" text="Delete" img="fa fa-trash " /><item type="separator" id="sep_3" />'
    + '</toolbar>', function () {
});

const courses_grid = tutAdminPrimary.cells('a').attachTree();

// courses_grid.setImagePath('http://' + location.host + '/dhtmlxsuite4/codebase/imgs/dhxtree_skyblue/');
courses_grid.enableHighlighting('1');
courses_grid.enableDragAndDrop('1', true);
courses_grid.setSkin('dhx_skyblue');
courses_grid.enableItemEditor(1);
courses_grid.enableTreeImages(false);
// courses_grid.enableTreeLines(true);
courses_grid.loadXML(PROJECT_URL + '1');




courses_toolbar.attachEvent("onClick", onCourses_toolbarClicked);
courses_grid.attachEvent("onSelect", onCourses_gridRowSelect);
courses_grid.attachEvent("onEditCell", onCourses_gridCellEdit);





courses_grid.attachEvent("onXLE", function (grid_obj, count) {
    // onCourses_gridRowSelect('10398');
    // courses_grid.openItem('10398');
    tutAdminPrimary.cells('a').progressOff();
});




courses_grid.attachEvent("onXLS", function (grid_obj) {
    tutAdminPrimary.cells('a').progressOn();
});





function onCourses_toolbarClicked(id) {
    switch (id) {
        case 'new':


            var newCourse = new dhtmlXWindows();
            var newCourseWin = newCourse.createWindow("w1", "", "", 380, 180);
            newCourseWin.setText('');
            newCourseWin.centerOnScreen();

            var formData = [
                {
                    type: "settings",
                    position: "label-left",
                    labelWidth: 60,
                    inputHeight: 23,
                    inputWidth: 240,
                    offsetLeft: 10,
                    offsetTop: 20,
                    className: "formlabel",
                    align: "right"
                },
                {type: "input", name: "title", label: "Title", className: "formlabel"},
                {type: "button", name: "save", value: "Save", className: "formlabel", offsetLeft: 70}

            ];

            var addTrainingForm = newCourseWin.attachForm(formData);

            addTrainingForm.attachEvent("onButtonClick", function (name) {

                if (addTrainingForm.getItemValue('title')) {
                    if (name == 'save') {
                        addTrainingForm.send(url + "4", "POST", function (loader, response) {
                            var parsedJSON = eval('(' + response + ')');
                            dhtmlx.message({title: 'Success', text: parsedJSON.message});
                            courses_grid.deleteChildItems(0);
                            courses_grid.loadXML(url + '19');
                        });
                    }
                } else {
                    dhtmlx.alert('Employee field empty');
                }
            });

            break;
        case 'refresh':
            // courses_grid.deleteChildItems(0);
            courses_grid.loadXML(PROJECT_URL + '1');

            break;

        case 'delete':
            //            var rowId = courses_grid.getSelectedItemId();
            var rowId = (projectId) ? projectId : courses_grid.getSelectedItemId();
            if (rowId) {
                dhtmlx.confirm({
                    title: "Confirm",
                    type: "confirm",
                    text: "Delete this course?",
                    callback: function (ok) {
                        if (ok) {
                            $.ajax({
                                url: url + "5", type: "POST", data: {id: rowId},
                                success: function (response) {
                                    var parsedJSON = eval('(' + response + ')');
                                    if (parsedJSON != null) {
                                        dhtmlx.message({title: 'Success', text: parsedJSON.message});
                                        courses_grid.deleteChildItems(0);
                                        courses_grid.loadXML(url + '19');
                                    }
                                }
                            });

                        } else {
                            return false;
                        }
                    }
                });
            } else {
                dhtmlx.alert('Please select record')
            }
            break;
    }
}

function onCourses_gridRowSelect(id) {
    const project_name = courses_grid.getItemText(id);
    tutAdminPrimary.cells("b").attachURL("presentation/content/?eid=20196&projectId="+id+"&title=" + project_name);
}




function onCourses_gridCellEdit(stage, rId, cInd, nValue, oValue) {
    // your code here
    const column = courses_grid.getColumnId(cInd);
    if (stage === 2) {
        $.ajax({
            url: url + "6", type: "POST", data: {id: rId, field: column, value: nValue},
            success: function (response) {
                var parsedJSON = eval('(' + response + ')');
                if (parsedJSON != null) {
                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                    courses_grid.clearAndLoad(url + '19');
                }
            }
        });
    }
}






