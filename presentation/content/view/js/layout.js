var myWidth, myHeight, global_skin = 'dhx_terrace', grid_skin = 'dhx_web';
var url = "/app/Stream/data.php?action=";
const PARENT_URL = "/api/session/"
const TRAINEE = {
    id: 9656,
    identifier: "1moche"
}


const VIDEO_URL = PARENT_URL + "video.php?trainee=" + TRAINEE.id + "&identifier=" + TRAINEE.identifier + "&action=";
const MODULE_URL = PARENT_URL + "module.php?trainee=" + TRAINEE.id + "&identifier=" + TRAINEE.identifier + "&action=";
const PROJECT_URL = PARENT_URL + "project.php?trainee=" + TRAINEE.id + "&identifier=" + TRAINEE.identifier + "&action=";


var media_file = '';
let mediaFilesGridHeight = 0;


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
//if (!projectId) {
//    tutAdminPrimary.cells('b').hideHeader();


parent_Module_layout = tutAdminPrimary.cells('a').attachLayout('1C');


var parentModuleTabbar = parent_Module_layout.cells("a").attachTabbar();
parentModuleTabbar.addTab("contentMain", "Contents Main", myWidth * 0.09);
parentModuleTabbar.addTab("uploader", "Moodle Videos", myWidth * 0.09);
parentModuleTabbar.addTab("subtitles_audio", "Subtitles & Audio", myWidth * 0.09);
// parentModuleTabbar.addTab("script", "Scripts", myWidth * 0.09);
parentModuleTabbar.setArrowsMode("auto");
parentModuleTabbar.tabs('contentMain').setActive();


var Module_layout = parentModuleTabbar.tabs('contentMain').attachLayout('3U');


Module_layout.cells('a').setText('Contents');
Module_layout.cells('a').setHeight(myHeight * 0.4);
Module_layout.cells('b').setWidth(myWidth * 0.28);
Module_layout.cells('b').hideHeader();
Module_layout.cells('c').hideHeader();

mediaFilesGridHeight = myHeight - ((myHeight * 0.24) + (myHeight * 0.13));


var ModulecontentGrid = Module_layout.cells('a').attachGrid();
ModulecontentGrid.setIconsPath('./preview/codebase/imgs/');
ModulecontentGrid.setHeader(["ID",  "Content Name", "Description", "Date updated"]);
ModulecontentGrid.setInitWidthsP('7,*,*,15');
ModulecontentGrid.init();

const mediaPrimaryTabLayout = Module_layout.cells('c').attachLayout('1C');


const mediaLayoutTabbar = mediaPrimaryTabLayout.cells("a").attachTabbar();
mediaLayoutTabbar.addTab("media", "Media", myWidth * 0.1);
mediaLayoutTabbar.addTab("comment", "Comment / Info", myWidth * 0.1);
mediaLayoutTabbar.setArrowsMode("auto");
mediaLayoutTabbar.tabs('media').setActive();


const mediaLayout = mediaLayoutTabbar.cells('media').attachLayout('1C');
mediaLayout.cells('a').hideHeader();

const media_files_grid = mediaLayout.cells('a').attachGrid();
media_files_grid.setIconsPath('./preview/codebase/imgs/');

media_files_grid.setHeader(["ID", "Title", "Description", "Author", "Views", "Uploaded", "map", "Url", "Hash#",]);
media_files_grid.setColumnIds("ID,file_name, description, author, views, Uploaded, disk, url, hash");
media_files_grid.setInitWidthsP('5,15,*,8,5,10,*,*,*');
media_files_grid.init();
/*
echo "<cell><![CDATA[" . $vid['description'] . "]]></cell>";
echo "<cell><![CDATA[" . $vid['user_first_name'] . "]]></cell>";
echo "<cell><![CDATA[" . $vid['total_views'] . "]]></cell>";
echo "<cell><![CDATA[" . $vid['updated_at'] . "]]></cell>";
echo "<cell><![CDATA[" . $vid['disk'] . "]]></cell>";
echo "<cell><![CDATA[" . $vid['videoLink_raw'] . "]]></cell>";
*/

const commentLayout = mediaLayoutTabbar.cells('comment').attachLayout('3T');
commentLayout.cells('a').hideHeader();
commentLayout.cells('a').setHeight(50);
commentLayout.cells('b').setText('Comment');
commentLayout.cells('c').setText('Timeline Info');


const mediaItemData = [
    {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 180, offsetLeft: 35},
    {type: "input", label: "ID", className: "formlabel", name: "ID"},
    {type: "newcolumn"},
    {type: "input", label: "Name", className: "formlabel", name: "mediaName", inputWidth: 250,},
];
const commentLayoutForm = commentLayout.cells('a').attachForm(mediaItemData);
commentLayoutForm.setReadonly("ID", true);
commentLayoutForm.setReadonly("mediaName", true);

const media_files_toolbar = mediaLayout.cells('a').attachToolbar();
media_files_toolbar.setIconset("awesome");
media_files_toolbar.loadStruct('<toolbar>'
    + '<item type="button" id="new" text="Upload" img="fa fa-upload " /><item type="separator" id="sep_1" />'
    + '<item type="button" id="download" text="Download" img="fa fa-download " /><item type="separator" id="sep_2" />'
    + '<item type="button" id="play" text="Play" img="fa fa-play " /><item type="separator" id="sep_7" />'
    + '<item type="button" id="replace" text="Replace File" img="fa fa-copy " /><item type="separator" id="sep_3" />'
    + '<item type="button" id="up" text="Up" img="fa fa-arrow-up" />'
    + '<item type="button" id="down" text="Down" img="fa fa-arrow-down" /><item type="separator" id="sep_5" />'
    + '<item type="button" id="delete" text="Delete" img="fa fa-trash " /><item type="separator" id="sep_6" />'
    //        + '<item type="button" id="regenerate" text="Generate Thumbs Texts" img="fa fa-cog " /><item type="separator" id="sep_7" />'
    + '</toolbar>', function () {
});


var modules_toolbar_form = Module_layout.cells('b').attachToolbar();
modules_toolbar_form.setIconset("awesome");
modules_toolbar_form.loadStruct('<toolbar>'
    + '<item type="button" id="new" text="New" img="fa fa-plus " /><item type="separator" id="sep_1" />'
    + '<item type="button" id="save" text="Save" img="fa fa-file " /><item type="separator" id="sep_2" />'
    + '<item type="button" id="delete" text="Delete" img="fa fa-trash " /><item type="separator" id="sep_4" />'
    + '</toolbar>', function () {
});

modules_toolbar = Module_layout.cells('a').attachToolbar();
modules_toolbar.setIconset("awesome");
modules_toolbar.loadStruct('<toolbar>'
    // + '<item type="button" id="new" text="New Content" img="fa fa-plus " /><item type="separator" id="sep_1" />'
    // + '<item type="button" id="up" text="Move up" img="fa fa-arrow-up" /><item type="separator" id="sep_2" />'
    // + '<item type="button" id="down" text="Move Down" img="fa fa-arrow-down" /><item type="separator" id="sep_3" />'
    // + '<item type="button" id="delete" text="Delete" img="fa fa-trash " /><item type="separator" id="sep_4" />'
    + '<item type="button" id="default" text="Default" img="fa fa-th-list fa-5x " /><item type="separator" id="sep_1" />'
    + '<item type="button" id="all" text="Show All" img="fa fa-list-ol fa-5x" /><item type="separator" id="sep_2" />'
    + '</toolbar>', function () {
});


const content_formData = [
    {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 230, offsetLeft: 35},
    {type: "input", label: "ID", className: "formlabel", name: "id", hidden: true},
    {type: "input", label: "User", className: "formlabel", name: "user_id", hidden: true},
    {type: "input", label: "ProjectID", className: "formlabel", name: "subject_id", hidden: true},
    {type: "input", label: "Title", className: "formlabel", name: "title"},
    // {type: "newcolumn"},
    {type: "input", label: "Description", className: "formlabel", name: "description"},
    {type: "calendar", label: "Date Updated", className: "formlabel", name: "updated_at"},
];
//

var content_form = Module_layout.cells('b').attachForm(content_formData);


const mediaCommentTinyMCE = commentLayout.cells('b').attachURL("/app/tinyMceDisplay_comments.php?id=mediacomment&name=mediacomment")

const mediaInfoTinyMCE = commentLayout.cells('c').attachURL("/app/tinyMceDisplay_info.php?id=mediainfo&name=mediainfo")








