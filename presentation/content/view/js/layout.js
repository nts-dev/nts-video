var myWidth, myHeight, global_skin = 'dhx_terrace', grid_skin = 'dhx_web';
let mediaFilesGridHeight = 0;
var url = baseURL + "app/Stream/data.php?action=";
var media_file = '';
var api_url = window.location.host + "/nts-video-api/api/";


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

var tutMainPrimary_layout = new dhtmlXLayoutObject({
//    parent: document.body,
    parent: "streamHomepage",
    pattern: "1C"
});

tutMainPrimary_layout.cells('a').hideHeader();
var profile_toolbar = tutMainPrimary_layout.cells("a").attachMenu();
profile_toolbar.setIconset("awesome");
profile_toolbar.setSkin("material");

if (!PROJECT_ID) {
    profile_toolbar.loadStruct('<menu>'
        + '<item id="guest">'
        + '<item id="logout" text="Logout"/>'
        + ' </item>'
        + '</menu>', function () {
    });

    profile_toolbar.setItemText("guest", "Welcome :" + username);

}


var tutAdminPrimary = tutMainPrimary_layout.cells("a").attachLayout('1C');


var parent_Module_layout;


parent_Module_layout = tutAdminPrimary.cells('a').attachLayout('1C');


var parentModuleTabbar = parent_Module_layout.cells("a").attachTabbar();
parentModuleTabbar.addTab("contentMain", "Contents Main", myWidth * 0.09);
parentModuleTabbar.addTab("uploader", "Moodle Videos", myWidth * 0.09);
parentModuleTabbar.addTab("subtitles_audio", "Subtitles & Audio", myWidth * 0.09);
// parentModuleTabbar.addTab("script", "Scripts", myWidth * 0.09);
parentModuleTabbar.setArrowsMode("auto");
parentModuleTabbar.tabs('contentMain').setActive();


var Module_layout = parentModuleTabbar.tabs('contentMain').attachLayout('3E');


Module_layout.cells('a').setText('Contents');
Module_layout.cells('a').setHeight(myHeight * 0.3);
Module_layout.cells('b').setHeight(myHeight * 0.2);
Module_layout.cells('b').hideHeader();
Module_layout.cells('c').hideHeader();

mediaFilesGridHeight = myHeight - ((myHeight * 0.3) + (myHeight * 0.2));

var ModulecontentGrid = Module_layout.cells('a').attachGrid();
ModulecontentGrid.setIconsPath('./preview/codebase/imgs/');
ModulecontentGrid.setHeader(["ID", "Sort", "Content Name", "Date updated", "Description"]);
ModulecontentGrid.setInitWidthsP('7,7,*,10,*');
ModulecontentGrid.init();

var media_files_layout = Module_layout.cells('c').attachLayout('1C');
media_files_layout.cells('a').setText('Video Files');


var media_files_grid = media_files_layout.cells('a').attachGrid();
media_files_grid.setIconsPath('./preview/codebase/imgs/');

media_files_grid.setHeader(["ID", "Sort", "Uploaded", "Media Name", "Alias", "Size", "Type"]);
media_files_grid.setColumnIds("ID,Sort,Uploaded,file_name,Alias,size,type");
media_files_grid.setInitWidthsP('8,9,19,*,15,10,0');
media_files_grid.init();


var media_files_toolbar = media_files_layout.cells('a').attachToolbar();
media_files_toolbar.setIconset("awesome");
media_files_toolbar.loadStruct('<toolbar>'
    + '<item type="button" id="new" text="Upload" img="fa fa-upload " /><item type="separator" id="sep_1" />'
    + '<item type="button" id="download" text="Download" img="fa fa-download " /><item type="separator" id="sep_2" />'
    + '<item type="button" id="play" text="Play" img="fa fa-play " /><item type="separator" id="sep_7" />'
    + '<item type="button" id="replace" text="Replace File" img="fa fa-copy " /><item type="separator" id="sep_3" />'
    + '<item type="button" id="up" text="Up" img="fa fa-arrow-up" />'
    + '<item type="button" id="down" text="Down" img="fa fa-arrow-down" /><item type="separator" id="sep_5" />'
    + '<item type="button" id="delete" text="Delete" img="fa fa-trash " /><item type="separator" id="sep_6" />'
    + '</toolbar>', function () {
});


var modules_toolbar_form = Module_layout.cells('b').attachToolbar();
modules_toolbar_form.setIconset("awesome");
modules_toolbar_form.loadStruct('<toolbar>'
    + '<item type="button" id="save" text="Save" img="fa fa-file " /><item type="separator" id="sep_1" />'
    + '</toolbar>', function () {
});

modules_toolbar = Module_layout.cells('a').attachToolbar();
modules_toolbar.setIconset("awesome");
modules_toolbar.loadStruct('<toolbar>'
    + '<item type="button" id="new" text="New Content" img="fa fa-plus " /><item type="separator" id="sep_1" />'
    + '<item type="button" id="up" text="Move up" img="fa fa-arrow-up" /><item type="separator" id="sep_2" />'
    + '<item type="button" id="down" text="Move Down" img="fa fa-arrow-down" /><item type="separator" id="sep_3" />'
    + '<item type="button" id="delete" text="Delete" img="fa fa-trash " /><item type="separator" id="sep_4" />'
    + '</toolbar>', function () {
});


var content_formData = [
    {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 180, offsetLeft: 35},
    {type: "input", label: "ID", className: "formlabel", name: "ID", hidden: true},
    {type: "input", label: "Sort", className: "formlabel", name: "Sort", value: ""},
    {type: "input", label: "Content  Name", className: "formlabel", name: "ModuleName"},
    {type: "newcolumn"},
    {type: "calendar", label: "Date Updated", className: "formlabel", name: "date_updated"},
    {type: "input", label: "Description", className: "formlabel", name: "Description"},
];
//

var content_form = Module_layout.cells('b').attachForm(content_formData);









