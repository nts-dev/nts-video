const playerWinWidth = 800;
const playerWinHeight = 750;

function startMediaPlayerWindow(media) {

    const playerMainWindow = new dhtmlXWindows();
    const playerWindow = playerMainWindow.createWindow("player_win", 0, 0, playerWinWidth, 400);
    // playerWindow.center();
    playerWindow.setText(media.title);


    const playerLayout = playerWindow.attachLayout('1C');
    playerLayout.cells('a').hideHeader();
    playerLayout.cells('a').attachURL("/videos/play/?id=" + media.id);


    playerWindow.attachEvent("onMaximize", function(win){
        // your code here
    });

    playerWindow.attachEvent("onMinimize", function(win){
        // your code here
    });
}

