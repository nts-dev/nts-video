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

const tutAdminPrimary = tutMainPrimary_layout.cells("a").attachLayout('2U');

tutAdminPrimary.cells('a').setText('Projects');
tutAdminPrimary.cells('a').setWidth(myWidth * 0.2);


















