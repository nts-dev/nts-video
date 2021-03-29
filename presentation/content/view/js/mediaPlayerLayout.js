// const playerWinWidth = 800;
// const playerWinHeightExact = mediaFilesGridHeight-70;


const playerWinWidth = 910;
const playerWinHeight = 850;

// const playerWinHeight = playerWinHeightExact > 560 ? playerWinHeightExact : 560;

function startMediaPlayerWindow(media) {

    const shareProps = {
        allowInfo: false,
        allowThumbs: false,
    }

    const playerMainWindow = new dhtmlXWindows();
    const playerWindow = playerMainWindow.createWindow("player_win", myWidth - playerWinWidth, myHeight - playerWinHeight, playerWinWidth, playerWinHeight);
    playerWindow.modal = true;
    // playerWindow.button("close").disable();
    playerWindow.button("park").disable();
    playerWindow.center();
    playerWindow.setText("");
    playerWindow.denyResize();
    playerWindow.denyPark();


    const playerLayout = playerWindow.attachLayout('2E');
    playerLayout.cells('a').hideHeader();
    playerLayout.cells('b').hideHeader();
    playerLayout.cells('a').setHeight(playerWinHeight * 0.8)
    playerLayout.cells('b').setHeight(playerWinHeight * 0.2);
    playerLayout.cells('a').attachURL("/play/?id=" + media.hash + '&showinfo=true&showthumbs=' + shareProps.allowThumbs);


    const formData = [

        {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 100, offsetLeft: 35},
        {type: "radio", name: "info", value: 1, label: "Comments / info"},
        {type: "newcolumn", width: 160},
        {type: "radio", name: "thumbnails", value: 2, label: "Sprit thumbnails"},
        // {type: "newcolumn", width: 100},
        // {type: "radio", name: "border", value: 3, label: "Boarder"},
    ];


    const shareLayout = playerLayout.cells('b').attachLayout('2E');
    shareLayout.cells('a').hideHeader();
    shareLayout.cells('b').hideHeader();


    const checkPropertiesForm = shareLayout.cells('a').attachForm(formData)

    var embedLink = '<iframe ' +
        'src="' + window.location.origin + '/play?id=' + media.hash + '&showinfo=' + shareProps.allowInfo + '&showthumbs=' + shareProps.allowThumbs + '" ' +
        'width="560" ' +
        'height="325" ' +
        'allowfullscreen></iframe>'

    checkPropertiesForm.attachEvent("onChange", function (name, value, state) {
        // your code here
        // if(state === false)
        //     checkPropertiesForm.uncheckItem(name, "1");
        switch (name) {
            case "info":
                shareProps.allowInfo = state
                break;
            case "thumbnails":
                shareProps.allowThumbs = state
                break;
        }
        embedLink = '<iframe ' +
            'src="' + window.location.origin + '/play?id=' + media.hash + '&showinfo=' + shareProps.allowInfo + '&showthumbs=' + shareProps.allowThumbs + '" ' +
            'width="560" ' +
            'height="325" ' +
            'allowfullscreen></iframe>'

        updateEmbedLink(embedLink)

    });


    shareLayout.cells("b").attachURL("/app/share_vidoe_code.php?id=filesFrame&name=filesIframe");


    playerWindow.attachEvent("onMaximize", function (win) {
        // your code here
        playerLayout.cells('a').setHeight(myHeight * 0.8);
    });

    playerWindow.attachEvent("onMinimize", function (win) {
        // your code here
        playerLayout.cells('b').setHeight(playerWinHeight * 0.2);
    });


    shareLayout.attachEvent("onContentLoaded", function (id) {
        updateEmbedLink(embedLink)
    });

    function updateEmbedLink(embedLink) {
        const ifr = shareLayout.cells('b').getFrame();
        ifr.contentWindow.setContent(embedLink);
    }
}

