/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//contats

var contentIndex = 0;
var mediaIndex = 0;

const projectId = projectFromProject.id;


var fileId = 0;


ModulecontentGrid.attachEvent("onRowSelect", onModulecontentGridRowSelect);
modules_toolbar.attachEvent("onClick", onModules_toolbarClicked);
modules_toolbar_form.attachEvent("onClick", onModules_toolbar_formClicked);
media_files_toolbar.attachEvent("onClick", onMedia_files_toolbarClicked);
media_files_grid.attachEvent("onRowSelect", onMedia_files_gridRowSelect);

audioLanguageTabToolbar.attachEvent("onClick", onAudioLanguageTabToolbarClicked);
audioLanguageGrid.attachEvent("onRowSelect", onAudioLanguageGridSelected);
audioGeneratorTabToolbar.attachEvent("onClick", onAudioGeneratorTabToolbarClicked);
audioTextTabToolbar.attachEvent("onClick", onAudioTextTabToolbarClicked);
audioGeneratorGrid.attachEvent("onRowSelect", onAudioGeneratorGridSelected);
audioGeneratorGrid.attachEvent("onEditCell", onAudioGeneratorGridEditCell);
audioMovieLayoutToolbar.attachEvent("onClick", onAudioMovieLayoutToolbarClicked);
audioMovieGrid.attachEvent("onRowSelect", onAudioMovieGridSelected);


profile_toolbar.attachEvent("onClick", function (id, zoneId, cas) {
    if (id === 'logout') {
        tutMainPrimary_layout.cells('a').progressOn();
        $.ajax({
            url: url + "22", type: "POST",
            success: function (response) {
                var parsedJSON = eval('(' + response + ')');
                if (parsedJSON.state == 'success') {
                    setTimeout(' window.location.href = "/_index.php"; ', 1000);
                    tutMainPrimary_layout.cells('a').progressOff();
                }
            }
        });
    }

});


onCourses_gridRowSelect(projectId);

// ModulecontentGrid.clearAndLoad(MODULE_URL + "1");

// media_files_grid.clearAndLoad(VIDEO_URL + '1');


//----------------------------initial xml loads----------------------------------


ModulecontentGrid.attachEvent("onXLE", function (grid_obj) {
    ModulecontentGrid.selectRow(contentIndex);
    var id = ModulecontentGrid.getRowId(contentIndex);
    onModulecontentGridRowSelect(id);
    Module_layout.cells('a').progressOff();
});

ModulecontentGrid.attachEvent("onXLS", function (grid_obj) {
    Module_layout.cells('a').progressOn()
});

audioGeneratorGrid.attachEvent("onXLE", function (grid_obj) {
    audioGeneratorGrid.selectRow(0);
    var id = audioGeneratorGrid.getRowId(0);
    onAudioGeneratorGridSelected(id);
//    audioSpeechLayout.cells('b').progressOff()
});

media_files_grid.attachEvent("onXLS", function (grid_obj) {
    mediaLayout.cells('a').progressOn();

});


media_files_grid.attachEvent("onXLE", function (grid_obj) {
    mediaLayout.cells('a').progressOff();

    media_files_grid.selectRow(media_files_grid.getRowsNum() - 1);
    var id = media_files_grid.getSelectedRowId();
    fileId = id;
    onMedia_files_gridRowSelect(id);


});


audioLanguageGrid.attachEvent("onXLE", function (grid_obj) {
    audioLanguageGrid.selectRow(0);
    var id = audioLanguageGrid.getRowId(0);
    onAudioLanguageGridSelected(id);
})

//-----------------------------functions-------------------------------------------


function saveFilmScript() {
    var mediaId = media_files_grid.getSelectedRowId();
    if (mediaId) {

        var contentIframe = scriptMainLayout.cells('a').getFrame();
        var content = contentIframe.contentWindow.tinyMCE.activeEditor.getContent();
        $.ajax({
            url: url + "59", type: "POST", data: {id: mediaId, content: content}, success: function (response) {
                var parsedJSON = eval('(' + response + ')');
                if (parsedJSON != null) {
                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                }
            }
        });


    } else {
        dhtmlx.alert("Please select media Item from main content")
    }
}

function saveMediaInfo() {
    const mediaId = media_files_grid.getSelectedRowId();
    if (!mediaId) {
        dhtmlx.alert("Please select media Item from main content")
        return
    }
    const mediaCommentContentIframe = commentLayout.cells('c').getFrame();
    const content = mediaCommentContentIframe.contentWindow.tinyMCE.activeEditor.getContent();
    $.ajax({
        url: url + "63", type: "POST", data: {id: mediaId, content: content},
        success: function (response) {
            const parsedJSON = eval('(' + response + ')');
            if (parsedJSON != null) {
                dhtmlx.message({title: 'Success', text: parsedJSON.message});
            }
        }
    });
}


function saveMediaComment() {
    const mediaId = media_files_grid.getSelectedRowId();

    if (!mediaId) {
        dhtmlx.alert("Please select media Item from main content")
        return
    }

    const mediaCommentContentIframe = commentLayout.cells('b').getFrame();
    const content = mediaCommentContentIframe.contentWindow.tinyMCE.activeEditor.getContent();
    $.ajax({
        url: url + "62", type: "POST", data: {id: mediaId, content: content},
        success: function (response) {
            const parsedJSON = eval('(' + response + ')');
            if (parsedJSON != null) {
                dhtmlx.message({title: 'Success', text: parsedJSON.message});
            }
        }
    });
}


function onCourses_gridRowSelect(id) {
    PROJECT_ID = id;
    mediaTreeGridState.project = id;
    ModulecontentGrid.clearAndLoad(MODULE_URL + "7&id=" + id);

    mediaTreeGrid.clearAndLoad(video_cut_url + "6&project=" + id);
}


function onModules_toolbarClicked(id) {
    //    var course = courses_grid.getSelectedItemId();
    const course = projectFromProject.id
    switch (id) {


        case 'default':
            onCourses_gridRowSelect(course);
            break;

        case 'all':
            ModulecontentGrid.clearAndLoad(MODULE_URL + "1");
            break;
    }
}

function sortContent(rowId, course, type, nextId, index) {
    $.ajax({
        url: url + "35", type: "POST", data: {id: rowId, action: type, nextId: nextId},
        success: function (response) {
            var parsedJSON = eval('(' + response + ')');
            contentIndex = index;
            if (parsedJSON != null && parsedJSON.status == 'success') {
                dhtmlx.message({title: 'Success', text: parsedJSON.message});
                ModulecontentGrid.clearAndLoad(MODULE_URL + "7&id=" + course)
            }
        }
    });
}


function onModulecontentGridRowSelect(id) {
    if (id < 1) return;
    content_form.load(MODULE_URL + '2&id=' + id);
    media_files_grid.clearAndLoad(VIDEO_URL + '7&id=' + id);
}


let isNewItem = false;

function onModules_toolbar_formClicked(id) {
    const contentId = ModulecontentGrid.getSelectedRowId();

    const courseId = projectFromProject.id;
    switch (id) {
        case 'save':

            const callback = function (response) {
                // your code here
                if (isNewItem)
                    isNewItem = false;
                // const parsedJSON = eval('(' + data.response + ')');
                console.log(response)
                if (response != null) {
                    dhtmlx.message({title: 'Success', text: "Item added"});
                    ModulecontentGrid.clearAndLoad(MODULE_URL + "7&id=" + courseId)
                }
            }
            isNewItem
                ? content_form.send(MODULE_URL + "4", "post", callback)
                : content_form.send(MODULE_URL + "5", "post", callback)
            break;
        case 'new':
            if (courseId == null) {
                dhtmlx.alert('Select project');
                return;
            }


            isNewItem = true;
            const dummyId = contentId + 2;
            ModulecontentGrid.addRow(dummyId, dummyId);
            content_form.clear();
            ModulecontentGrid.selectRow(ModulecontentGrid.getRowIndex(dummyId));
            content_form.setItemValue("subject_id", courseId);

            break;

        case 'delete':
            const rowId = ModulecontentGrid.getSelectedRowId();
            if (rowId) {
                dhtmlx.confirm({
                    title: "Confirm",
                    type: "confirm",
                    text: "Delete this content?",
                    callback: function (ok) {
                        if (ok) {
                            const callbackFromDeleteAction = function (response) {
                                console.log(response)
                                if (response != null) {
                                    dhtmlx.message({title: 'Success', text: "Delete success"});
                                    ModulecontentGrid.clearAndLoad(MODULE_URL + "7&id=" + courseId)
                                }
                            }
                            content_form.send(MODULE_URL + "3", "post", callbackFromDeleteAction)
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

function onMedia_files_toolbarClicked(id) {
    const rowId = ModulecontentGrid.getSelectedRowId();
    const mediaId = media_files_grid.getSelectedRowId();


    // if (mediaId) {
    const rowIndex = media_files_grid.getRowIndex(mediaId);
    // const hashColIndex = media_files_grid.getColIndexById("hash");
    // const hash = media_files_grid.cells(mediaId, hashColIndex).getValue();

    switch (id) {
        case 'new':
            uploadMediaFile(rowId, 'new', 0);
            break;
        case 'replace':
            if (mediaId) {
                uploadMediaFile(rowId, 'replace', mediaId);
            }
            break;

        case 'play': {
            if (mediaId) {
                /**
                 * TODO implement hash
                 * @type {{id, title: string, hash}}
                 */
                const objMedia = {
                    id: mediaId,
                    hash: "",
                    title: "media title"
                };
                startMediaPlayerWindow(objMedia);

            }

        }
            break;

        case 'delete':

            if (mediaId) {
                dhtmlx.confirm({
                    title: "Confirm",
                    type: "confirm",
                    text: "Delete this file?",
                    callback: function (ok) {
                        if (ok) {
                            $.ajax({
                                url: url + "15", type: "POST", data: {id: mediaId},
                                success: function (response) {
                                    var parsedJSON = eval('(' + response + ')');
                                    if (parsedJSON != null) {
                                        dhtmlx.message({title: 'Success', text: parsedJSON.message});
                                        media_files_grid.clearAndLoad(VIDEO_URL + '7&id=' + rowId);
                                    }
                                }
                            });

                        } else {
                            return false;
                        }
                    }
                });
            } else {
                dhtmlx.alert('Please select record');
            }

            break;
        case 'up':
            var index = rowIndex - 1;
            var nextId = media_files_grid.getRowId(index);
            //             alert(index +"   "+ nextId)
            if (nextId)
                sortMedia(mediaId, rowId, 'up', nextId, index);
            else
                dhtmlx.alert('Cant sort further');
            break;

        case 'down':
            var index = rowIndex + 1;
            var nextId = media_files_grid.getRowId(index);

            //             alert(index +"   "+ nextId)
            if (nextId)
                sortMedia(mediaId, rowId, 'down', nextId, index);
            else
                dhtmlx.alert('Cant sort further');
            break;

        case 'download':
            if (mediaId) {
                window.location.href = url + "39&projectId=" + projectId + "&category=" + rowId + "&file=" + mediaId;
            } else {
                dhtmlx.alert('Please select file to download');
            }
            break;
        case 'regenerate':
            if (mediaId) {
                overWriteThumbTexts(alias)
            } else
                dhtmlx.alert('Please select file to download');
            break;
    }
    // } else {
    //     dhtmlx.alert('Please select file to replace');
    // }
}


function downloadURI(uri, name) {
    const link = document.createElement("a");
    link.download = name;
    link.href = uri;
    link.click();
}


function overWriteThumbTexts(alias) {

    generatedAudioClipMainLayout.cells('b').progressOn();
    $.ajax({
        url: url + "40", type: "GET", data: {file: alias}, success: function (response) {
            var parsedJSON = eval('(' + response + ')');
            if (parsedJSON != null) {
                dhtmlx.message({title: 'Success', text: parsedJSON.message});

                overwriteThumbnails(alias);

            }
        }
    });
}

function overwriteThumbnails(alias) {
    mediaLayout.cells('a').progressOn();
    $.ajax({
        url: "/app/Stream/extractTime.php", type: "GET", data: {file: alias}, success: function (response) {
            var parsedJSON = eval('(' + response + ')');
            if (parsedJSON != null && parsedJSON.call !== 1) {

                if (parsedJSON.status == "fail")
                    generatedAudioClipMainLayout.cells('b').progressOff();
                else
                    generateSpriteWithTextsService(alias);
                dhtmlx.message({title: 'Success', text: parsedJSON.message});
            } else {
                mediaLayout.cells('a').progressOff();
                generatedAudioClipMainLayout.cells('b').progressOff();
                dhtmlx.alert(parsedJSON.message);
            }
        }
    });
}

function generateSpriteWithTextsService(alias) {
    $.ajax({
        url: "/app/Stream/TranscoderREST.php", type: "GET", data: {file: alias}, success: function (response) {
            var parsedJSON = eval('(' + response + ')');
            if (parsedJSON != null) {

                mediaLayout.cells('a').progressOff();
                generatedAudioClipMainLayout.cells('b').progressOff();
                dhtmlx.alert(parsedJSON.message);
            }
        }
    });
}

function uploadFile(media, moduleId, subjectId, action) {

    if (media < 1 || moduleId < 1 || subjectId < 1)
        return

    const fileUploadMainWindow = new dhtmlXWindows();
    const fileUploadWindow = fileUploadMainWindow.createWindow("uploadpic_win", 0, 0, 480, 600);
    fileUploadWindow.center();
    fileUploadWindow.setText("Upload  file");

    // fileUploadWindow.attachLayout('F4');

    const fileUploadLayout = fileUploadWindow.attachLayout('1C');
    fileUploadLayout.cells('a').hideHeader();


    fileUploadLayout.attachEvent("onContentLoaded", function (id) {

    });

    const uploadBoxformData = [

        {
            type: "block", list: [
                {type: "settings", offsetTop: 20, offsetLeft: 30, labelWidth: 100, inputWidth: 280,},
                {type: "combo", label: "Project /Subject", className: "formlabel", name: "subject_id", required: true},
                {type: "combo", label: "Category", className: "formlabel", name: "module_id", required: true},
                {type: "input", label: "Title", className: "formlabel", name: "title", required: true},
                {type: "input", label: "Description", className: "formlabel", name: "description", required: true},
                {
                    type: "fieldset", label: "Your file",
                    list: [{
                        type: "upload",
                        name: "myFiles",
                        inputWidth: 310,
                        url: url + "13&id=" + moduleId + "&kind=" + action + "&media=" + media + "&project=" + projectId,
                        swfPath: "http://" + location.host + "/dhtmlxSuite5/codebase/ext/uploader.swf",
                        required: true
                    }]
                }
            ]
        }
    ];

    const uploadfileForm = fileUploadLayout.cells('a').attachForm(uploadBoxformData);
    const projectCombo = uploadfileForm.getCombo("subject_id");
    const moduleCombo = uploadfileForm.getCombo("module_id");


    /**
     * TODO Project combo
     */

    projectCombo.load(PROJECT_URL + "6", function(response) {
        // uploadfileForm.setItemValue("subject_id", 52);
    });


    moduleCombo.load(MODULE_URL + "8", function(response) {
        uploadfileForm.setItemValue("module_id", 52);
    });



    uploadfileForm.attachEvent("onFileAdd", function (realName) {
        const accepted = ["mp3", "mp4", "webm"];
        const ext = realName.substring(realName.length - 3, realName.length);
        if (!accepted.includes(ext)) {
            dhtmlx.alert({title: "Error", text: realName + " should be of type mp3/4"})
        }
    });


    uploadfileForm.attachEvent("onUploadFail", function (name) {
        dhtmlx.alert({
            title: "Error",
            text: "There was an error while uploading " + name + ". Please check file type"
        })

    });

    uploadfileForm.attachEvent("onUploadComplete", function () {


        dhtmlx.message('file uploaded');
        clearForm(uploadfileForm);


        media_files_grid.clearAndLoad(VIDEO_URL + '7&id=' + moduleId, function () {
//                vid_libGrid.clearAndLoad(url + '7&id=' + PROJECT_ID);
            $.ajax({
                url: url + "41",
                type: "GET",
                data: {file: media_files_grid.getSelectedRowId()},
                success: function (response) {
                    const parsedJSON = eval('(' + response + ')');
                }
            });
        });

    });

}

function uploadMediaFile(rowId, action, media) {

    return uploadFile(200, rowId, projectId, action);

    if (rowId) {
        var fileUploadMainWindow = new dhtmlXWindows();
        var fileUploadWindow = fileUploadMainWindow.createWindow("uploadpic_win", 0, 0, 500, 300);
        fileUploadWindow.center();
        fileUploadWindow.setText("File details");

        // fileUploadWindow.attachLayout('F4');

        const fileUploadLayout = fileUploadWindow.attachLayout('1C');
        fileUploadLayout.cells('a').hideHeader();


        const upload_formData = [
            {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 230, offsetLeft: 35},
            {type: "input", label: "id", className: "formlabel", name: "id", hidden: true},
            {type: "input", label: "id", className: "formlabel", name: "subject_id", hidden: true, value: projectId},
            {type: "input", label: "id", className: "formlabel", name: "module_id", hidden: true, value: rowId},
            {type: "input", label: "Title", className: "formlabel", name: "title"},

            {type: "input", label: "Description", className: "formlabel", name: "description"},
            {type: "button", label: "Proceed", className: "formlabel", name: "submit", value: "Proceed"},
        ];


        //         //add form
        const uploadfileForm = fileUploadLayout.cells('a').attachForm(upload_formData);
        uploadfileForm.enableLiveValidation(true);


        uploadfileForm.attachEvent("onButtonClick", function (id) {
            if (id === "submit") {
                // document.getElementById("realForm").submit();
                uploadfileForm.send(VIDEO_URL + "4", "post", function () {
                    console.log("sent")
                    uploadFile(200, rowId, projectId, action)
                    fileUploadWindow.close();
                });
            }
        });

    }
}

function clearForm(form) {
    form.getUploader('myFiles').clear();
}

function saveMediaCommentsContent() {
    var mediaId = media_files_grid.getSelectedRowId(),
        contentIframe = mediafileCommentLayout.cells('a').getFrame(),
        text = contentIframe.contentWindow.tinyMCE.activeEditor.getContent({format: 'html'});
    if (mediaId) {
        $.ajax({
            url: url + "17", type: "POST", data: {id: mediaId, text: text}, success: function (response) {
                var parsedJSON = eval('(' + response + ')');
                if (parsedJSON != null) {
                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                    //                media_files_grid.clearAndLoad(url + '14&id=' + rowId);
                }
            }
        });
    } else {
        dhtmlx.alert('Please select media file');
    }
}


function onMedia_files_gridRowSelect(id) {


    if (id === null || id < 1)
        return


    audioLanguageGrid.clearAndLoad(url + "48&media=" + id);
    commentLayoutForm.setItemValue("ID", id);

    const index = media_files_grid.getColIndexById("file_name");
    const mediaItem = media_files_grid.cells(id, index).getValue();
    commentLayoutForm.setItemValue("mediaName", mediaItem);
    updateMediaCommentIframeContent(id)
    updateMediaInfoIframeContent(id)
    updateScriptIframeContent(id)
//
// //    subtitleMiniTemplateTimingGrid.clearAndLoad(url + "25&id=" + id);
//     $.ajax({
//         url: url + "18", type: "POST", data: {id: id}, success: function (response) {
//             var parsedJSON = eval('(' + response + ')');
//             if (parsedJSON != null && parsedJSON.content != "null") {
// //                contentIframe.contentWindow.tinyMCE.activeEditor.setContent(parsedJSON.content); ..............................To be added later..............
//             }
//         }
//     });


}


function updateScriptIframeContent(id) {
    const _contentIframe = scriptMainLayout.cells('a').getFrame();
    _contentIframe.contentWindow.tinyMCE.activeEditor.setContent('');
    $.ajax({
            url: url + "60", type: "POST", data: {id: id}, success: function (response) {
                const parsedJSON = eval('(' + response + ')');
                if (parsedJSON != null && parsedJSON.response === true)
                    _contentIframe.contentWindow.tinyMCE.activeEditor.setContent(parsedJSON.content);

            }
        }
    );
}

function updateMediaCommentIframeContent(id) {
    const _contentIframe = commentLayout.cells('b').getFrame();
    _contentIframe.contentWindow.tinyMCE.activeEditor.setContent('');
    $.ajax({
            url: url + "65", type: "POST", data: {id: id}, success: function (response) {
                const parsedJSON = eval('(' + response + ')');
                if (parsedJSON != null && parsedJSON.response === true)
                    _contentIframe.contentWindow.tinyMCE.activeEditor.setContent(parsedJSON.content);

            }
        }
    );
}


function updateMediaInfoIframeContent(id) {
    const _contentIframe = commentLayout.cells('c').getFrame();
    _contentIframe.contentWindow.tinyMCE.activeEditor.setContent('');
    $.ajax({
            url: url + "64", type: "POST", data: {id: id}, success: function (response) {
                const parsedJSON = eval('(' + response + ')');
                if (parsedJSON != null && parsedJSON.response === true)
                    _contentIframe.contentWindow.tinyMCE.activeEditor.setContent(parsedJSON.content);

            }
        }
    );
}


function onAudioLanguageTabToolbarClicked(id) {
    var language = audioLanguageTabToolbar.getListOptionSelected('language');
    var language_text = audioLanguageTabToolbar.getListOptionText('language', language);
    var media = media_files_grid.getSelectedRowId();
    var selectedLanguageID = audioLanguageGrid.getSelectedRowId();

    switch (id) {
        case "delete":
            if (selectedLanguageID) {
                audioSubtitleMainLayout.cells('a').progressOn();
                var audioLanguageItemID = audioLanguageGrid.cells(selectedLanguageID, 0).getValue();

                dhtmlx.confirm({
                    title: "Confirm",
                    type: "confirm",
                    text: "Delete this language?",
                    callback: function (ok) {
                        if (ok) {
                            $.ajax({
                                url: url + "58",
                                type: "GET",
                                data: {id: audioLanguageItemID},
                                success: function (response) {
                                    var parsedJSON = eval('(' + response + ')');
                                    if (parsedJSON != null) {
                                        dhtmlx.message({title: 'Success', text: parsedJSON.message});
                                        audioLanguageGrid.clearAndLoad(url + "48&media=" + media);
                                        audioSubtitleMainLayout.cells('a').progressOff();

                                    }
                                }
                            });
                        } else {
                            audioSubtitleMainLayout.cells('a').progressOff();
                            return false;
                        }
                    }
                });
            } else {
                dhtmlx.alert("please select media file")
                audioSubtitleMainLayout.cells('a').progressOff();
            }
            break;

        default:
            if (media) {
                audioSubtitleMainLayout.cells('a').progressOn();
                dhtmlx.confirm({
                    title: "Confirm",
                    type: "confirm",
                    text: "Add " + language_text,
                    callback: function (ok) {
                        if (ok) {
                            $.ajax({
                                url: url + "47",
                                type: "POST",
                                data: {media: media, language: language},
                                success: function (response) {
                                    var parsedJSON = eval('(' + response + ')');
                                    if (parsedJSON != null) {
                                        dhtmlx.message({title: 'Success', text: parsedJSON.message});
                                        audioLanguageGrid.clearAndLoad(url + "48&media=" + media);
                                        audioSubtitleMainLayout.cells('a').progressOff();

                                    }
                                }
                            });
                        } else {
                            audioSubtitleMainLayout.cells('a').progressOff();
                            return false;
                        }
                    }
                });
            } else {
                dhtmlx.alert("please select media file")
                audioSubtitleMainLayout.cells('a').progressOff();
            }
            break;

    }

}


function onOverlayFilesLayoutToolbarClicked(id) {
    var contentIframe = overlayFilesLayout.cells('a').getFrame();
    var content = contentIframe.contentWindow.getContent();
    var mediaid = media_files_grid.getSelectedRowId();
    var colIndex = media_files_grid.getColIndexById("Alias");
    var alias = media_files_grid.cells(mediaid, colIndex).getValue();
    switch (id) {
        case 'save':
            $.ajax({
                url: url + "42",
                type: "POST",
                data: {content: content, id: mediaid, lang: 1, field: 'overlaying_text'},
                success: function (response) {
                    var parsedJSON = eval('(' + response + ')');
                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                }
            });
            break;

        case 'generateThumbnailTexts':
            overWriteThumbTexts(alias);
            break;
    }
}

function onAudioLanguageGridSelected(id) {
    var audioLanguageItemID = audioLanguageGrid.cells(id, 0).getValue();
    audioGeneratorGrid.clearAndLoad(url + "49&id=" + audioLanguageItemID);
    audioMovieGrid.clearAndLoad(url + "55&id=" + audioLanguageItemID);
}

function onAudioGeneratorTabToolbarClicked(id) {
    var text_lang = audioLanguageGrid.getSelectedRowId();
    var mediaid = media_files_grid.getSelectedRowId();
    var audioLanguageItemID = audioLanguageGrid.cells(text_lang, 0).getValue();
    var count = audioGeneratorGrid.getRowsNum();
    var clipDetailID = audioGeneratorGrid.getSelectedRowId();
    var last_endTime = '';

    if (count > 0) {
        var last_id = audioGeneratorGrid.getRowId(audioGeneratorGrid.getRowsNum() - 1);
        last_endTime = audioGeneratorGrid.cells(last_id, 2).getValue();
    } else
        last_endTime = '00:01:00';

    switch (id) {
        case 'new':
            $.ajax({
                url: url + "50",
                type: "POST",
                data: {id: audioLanguageItemID, endTime: last_endTime},
                success: function (response) {
                    var parsedJSON = eval('(' + response + ')');
                    audioGeneratorGrid.clearAndLoad(url + "49&id=" + audioLanguageItemID);
                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                }
            });
            break;
        case 'delete':
            if (clipDetailID) {
                dhtmlx.confirm({
                    title: "Confirm",
                    type: "confirm",
                    text: "Delete this file?",
                    callback: function (ok) {
                        if (ok) {
                            $.ajax({
                                url: url + "54", type: "POST", data: {id: clipDetailID}, success: function (response) {
                                    var parsedJSON = eval('(' + response + ')');
                                    audioGeneratorGrid.clearAndLoad(url + "49&id=" + audioLanguageItemID);
                                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                                }
                            });
                        } else {
                            return false;
                        }
                    }
                });
            } else
                dhtmlx.alert('No Item selected');

            break;

        case 'generate':
//            var text = audioTextLayout.getContent();
            generatedAudioClipMainLayout.cells('b').progressOn();
            $.ajax({
                url: "Google/tts_run.php",
                type: "GET",
                data: {id: mediaid, lang: text_lang},
                success: function (response) {
                    dhtmlx.message({title: 'Success', text: 'Action complete'});
                    audioGeneratorGrid.updateFromXML(url + "49&id=" + audioLanguageItemID);
                    generatedAudioClipMainLayout.cells('b').progressOff();

                }
            });

            break;

        case 'subtitle':
            generatedAudioClipMainLayout.cells('b').progressOn();
            $.ajax({
                url: url + "56",
                type: "POST",
                data: {id: audioLanguageItemID, path: "f_" + mediaid, lang: text_lang},
                success: function (response) {
                    var parsedJSON = eval('(' + response + ')');
                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                    generatedAudioClipMainLayout.cells('b').progressOff();
                }
            })
            break;

        case 'overlaying':
            var colIndex = media_files_grid.getColIndexById("Alias");
            var alias = media_files_grid.cells(mediaid, colIndex).getValue();
            overWriteThumbTexts(alias);
            break;
    }

}

function onAudioTextTabToolbarClicked(id) {
    var mediaid = media_files_grid.getSelectedRowId();
    var audioItemId = audioGeneratorGrid.getSelectedRowId();
    var colIndex = audioGeneratorGrid.getColIndexById("SortID");
    var sort = audioGeneratorGrid.cells(audioItemId, colIndex).getValue();
    var text = audioTextLayout.getContent();
    var text_lang = audioLanguageGrid.getSelectedRowId();
    var audioLanguageItemID = audioLanguageGrid.cells(text_lang, 0).getValue();


    if (id === "save") {
        if (audioItemId)
            $.ajax({
                url: url + "51",
                type: "POST",
                data: {media: mediaid, item: audioItemId, sort: sort, content: text, lang: text_lang},
                success: function (response) {
                    var parsedJSON = eval('(' + response + ')');
                    audioGeneratorGrid.clearAndLoad(url + "49&id=" + audioLanguageItemID);
                    dhtmlx.message({title: 'Success', text: parsedJSON.message});
                }
            });
    }
}

function onAudioGeneratorGridSelected(id) {
    audioMovieLayout.cells('b').detachObject(true);
    audioTextLayout.setContent(""); //unset content
    if (id) {
        var mediaid = media_files_grid.getSelectedRowId();
        var colIndex = audioGeneratorGrid.getColIndexById("SortID");
        var sort = audioGeneratorGrid.cells(id, colIndex).getValue();
        var lang = audioLanguageGrid.getSelectedRowId();
        $.ajax({
            url: url + "52", type: "POST", data: {id: id}, success: function (response) {
                var parsedJSON = eval('(' + response + ')');
                audioTextLayout.setContent(parsedJSON.content);
                audioMovieLayout.cells('b').attachURL("play/audioplayer.php?file=" + sort + ".mp3&path=f_" + mediaid + "&lang=" + lang + "&version=" + Math.random());
            }
        });
    }

}


function onAudioGeneratorGridEditCell(stage, rId, cInd, nValue, oValue) {
    var field = audioGeneratorGrid.getColumnId(cInd);
    var lang = audioLanguageGrid.getSelectedRowId();
    var audioLanguageItemID = audioLanguageGrid.cells(lang, 0).getValue();
    if (stage === 2) {

        $.ajax({
            url: url + "53", type: "POST", data: {id: rId, value: nValue, field: field}, success: function (response) {
                var parsedJSON = eval('(' + response + ')');
                dhtmlx.message({title: 'Success', text: parsedJSON.message});
                audioGeneratorGrid.updateFromXML(url + "49&id=" + audioLanguageItemID);
            }
        });
    }
}

function onAudioMovieLayoutToolbarClicked(id) {
    var text_langId = audioLanguageGrid.getSelectedRowId();
    var mediaid = media_files_grid.getSelectedRowId();
    var audioLanguageItemID = audioLanguageGrid.cells(text_langId, 0).getValue();
    if (id === 'generate') {
        $.ajax({
            url: "Google/audioMovie.php",
            type: "POST",
            data: {id: audioLanguageItemID, path: "f_" + mediaid, lang: text_langId},
            success: function (response) {
                var parsedJSON = eval('(' + response + ')');
                dhtmlx.message({title: 'Success', text: parsedJSON.message});
                audioMovieGrid.updateFromXML(url + "55&id=" + audioLanguageItemID);
            }
        });
    }
}

function onAudioMovieGridSelected(id) {
    var mediaid = media_files_grid.getSelectedRowId();
    var lang = audioLanguageGrid.getSelectedRowId();
    audioMovieLayout.cells('b').detachObject(true);
    audioMovieLayout.cells('b').attachURL("play/audioplayer.php?file=audiomovie.mp3&path=f_" + mediaid + "&lang=" + lang + "&version=" + Math.random() + "&src=1");
}


function audioTranslatorWindow(language, audio_dbID) {
    var audioTranslator = new dhtmlXWindows();
    var audioTranslatorWin = audioTranslator.createWindow("w1", "", "", 380, 180);
    audioTranslatorWin.setText('');
    audioTranslatorWin.centerOnScreen();

    var formData = [
        {
            type: "settings",
            position: "label-left",
            labelWidth: 140,
            inputHeight: 23,
            inputWidth: 140,
            offsetLeft: 10,
            offsetTop: 20,
            className: "formlabel",
            align: "right"
        },
        {type: "combo", name: "language", label: "Translate from " + language + " to", className: "formlabel"},
        {type: "button", name: "save", value: "Proceed", className: "formlabel", offsetLeft: 150}

    ];
    var addLanguageForm = audioTranslatorWin.attachForm(formData);
    var languageCombo = addLanguageForm.getCombo("language");
    var languageValues = availableAudioGrid.getAllRowIds();

    languageCombo.addOption([
        [1, "English"],
        [4, "Dutch"],
        [7, "German"],
        [6, "French"],
        [8, "Swahili"],
        [9, "Spanish"],
        [11, "Malaysia"]
    ]);


    addLanguageForm.attachEvent("onChange", function (name, value) {
        //your code here
        for (i = 0; i < languageValues.length; i++) {
            console.log(languageValues[i])
            if (parseInt(languageValues[i]) === parseInt(value))
                dhtmlx.alert("A version of this language already exist")
        }
    });


    addLanguageForm.attachEvent("onButtonClick", function (name) {
        if (name === "save") {
            var value = addLanguageForm.getItemValue("language");
            if (value) {
                for (i = 0; i < languageValues.length; i++) {
                    if (parseInt(languageValues[i]) === parseInt(value))
                        dhtmlx.alert("A version of this language already exist")
                    else {
                        audioTranslatorWin.hide()
                        audioTranslatorProgressWindow(audio_dbID, value)
                        break;
                    }

                }
            } else
                dhtmlx.alert("Please select language")
        }

    });


}
