$(document).ready(function () {
    /* ================= INVENTORY ================= */
    $(".inventory_container").click(function () {
    document.title = "Stock Controller - Inventory";
    $(".HOME").fadeOut(150);
    $(".INVENTORY").fadeIn(300);
    });

    $(".StockBatch").click(function () {
    document.title = "Stock Controller - Stock Batch";
    $(".ProductInfoContainer, .ProductInfoContainerbtns").fadeOut(150);
    $(".StockBatchContainer, .StockBatchContainerbtns").fadeIn(300);

    $("subtitle3, .subtitle4, .subtitle5").removeClass("Bold").fadeOut(200);
    $(".subtitle7").removeClass("Normal").addClass("Bold").fadeIn(500);

    $(".ProdInfo, .PullOutLog").removeClass("active");
    $(".StockBatch").addClass("active");
    });

    $(".PullOutLog").click(function () {
    document.title = "Stock Controller - Pull Out Log";
    $(".ProductInfoContainer, .ProductInfoContainerbtns, .StockBatchContainer, .StockBatchContainerbtns").fadeOut(150);
    $(".PullOutLogGroup").fadeIn(300);

    $("subtitle3, .subtitle4, .subtitle5, .subtitle7, .subtitle6, .subtitle8, .subtitle9").removeClass("Bold").fadeOut(200);
    $(".subtitle10").removeClass("Normal").addClass("Bold").fadeIn(500);

    $(".ProdInfo, .StockBatch").removeClass("active");
    $(".PullOutLog").addClass("active");
    });

    $(".ProdInfo").click(function () {
    document.title = "Stock Controller - Product Information";
    $(".StockBatchContainer, .StockBatchContainerbtns").fadeOut(15);
    $(".ProductInfoContainer, .ProductInfoContainerbtns").fadeIn(300);

    $(".subtitle3, .subtitle4, .subtitle7").removeClass("Bold").fadeOut(200);
    $(".subtitle5").removeClass("Normal").addClass("Bold").fadeIn(500);

    $(".StockBatch, .PullOutLog").removeClass("active");
    $(".ProdInfo").addClass("active");
    });

    $(".addProductBtn").click(function () {
    document.title = "Stock Controller - Add Product";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle4").addClass("Bold").fadeIn(200);

    $(".TireTbl, .addProductBtn, .TrashGroup, .RimsGroup, .BatteryGroup, .TiresGroup").fadeOut(150);
    $(".addProductContainer, .cancel_btn, .add_btn").fadeIn(300);

    $(".inventory").attr("src", "assets/inventory2.png");
    });

    $(".cancel_btn, .add_btn, .Removebtnskuid1, .Backbtnskuid1").click(function () {

    document.title = "Stock Controller - Inventory";

    $(".addProductContainer, .cancel_btn, .add_btn, .StockBatchContainer, .StockBatchContainerbtns, .AddStockBatchContainer, .StockBatchInfoContainer, .Backbtnskuid1, .StockBatchInfoContainerbtns, .PullOutLogGroup").fadeOut(150);
    $(".skuid1Container, .Updatebtnskuid1, .Removebtnskuid1, .Backbtnskuid1, .BattProductInfoContainerbtns, .BatterySKU1Container").fadeOut(150);

    $(".TrashGroup, .RimsGroup, .BatteryGroup").fadeOut(150);

    $(".BatteryTab, .TrashTab, .RimsTab").removeClass("active");
    $(".TiresTab").addClass("active");

    $(".TireTbl, .trackinventorypage, .addProductBtn, .TiresGroup").fadeIn(300);

    $(".subtitle3").removeClass("Normal").addClass("Bold");
    $(".subtitle4, .subtitle5, subtitle3, .subtitle7, .subtitle8, .subtitle9, .subtitle10").removeClass("Bold").fadeOut(200);

    $(".inventory").attr("src", "assets/inventory3.png");
    });

    $(".Updatebtnskuid1").click(function () {
    document.title = "Stock Controller - Update Product";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle4").removeClass("Bold").addClass("Normal");
    $(".subtitle5").removeClass("Bold").addClass("Normal");
    $(".subtitle6").addClass("Bold").removeClass("Normal").fadeIn(200);

    $(".skuid1Container, .Removebtnskuid1, .Updatebtnskuid1, .Backbtnskuid1").fadeOut(150);
    $(".UpdateProdInfoContainer, .UpdateProdInfoTitle, .Updatebtnskuid2, .Backbtnskuid2").fadeIn(300);

    });

    $(".BNumIdASB").click(function () {
    document.title = "Stock Controller - Batch Information";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle4").removeClass("Bold").addClass("Normal");
    $(".subtitle5").removeClass("Bold").addClass("Normal");
    $(".subtitle6").removeClass("Bold").addClass("Normal");
    $(".subtitle7").removeClass("Bold").addClass("Normal");
    $(".subtitle8").removeClass("Bold").addClass("Normal");
    $(".subtitle9").addClass("Bold").removeClass("Normal").fadeIn(200);

    $(".skuid1Container, .Removebtnskuid1, .Updatebtnskuid1, .Backbtnskuid1, .StockBatchContainer, .StockBatchContainerbtns, .ProductInfoContainer, .ProductInfoContainerbtns, .add_btnASB").fadeOut(150);
    $(".StockBatchInfoContainer, .Backbtnskuid1, .StockBatchInfoContainerbtns").fadeIn(300);

    });

    $(".AddStockbtnskuid1").click(function () {
    document.title = "Stock Controller - Add New Stock";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle4").removeClass("Bold").addClass("Normal");
    $(".subtitle5").removeClass("Bold").addClass("Normal");
    $(".subtitle6").removeClass("Bold").addClass("Normal");
    $(".subtitle7").removeClass("Bold").addClass("Normal");
    $(".subtitle8").addClass("Bold").removeClass("Normal").fadeIn(200);

    $(".skuid1Container, .Removebtnskuid1, .Updatebtnskuid1, .Backbtnskuid1, .StockBatchContainer, .StockBatchContainerbtns, .ProductInfoContainer, .ProductInfoContainerbtns").fadeOut(150);
    $(".StockBatchInfoContainer, .StockBatchInfoContainerbtns").fadeIn(300);

    });

    $(".add_btnASB").click(function () {
    document.title = "Stock Controller - Add Stock";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle4").removeClass("Bold").addClass("Normal").fadeOut(200);
    $(".subtitle5").removeClass("Bold").addClass("Normal").fadeOut(200);
    $(".subtitle6").removeClass("Bold").addClass("Normal").fadeOut(200);
    $(".subtitle8").removeClass("Bold").addClass("Normal").fadeOut(200);
    $(".subtitle7").addClass("Bold").removeClass("Normal").fadeIn(200);

    $(".AddStockBatchContainer, .Removebtnskuid1, .Updatebtnskuid1, .ProductInfoContainer, .ProductInfoContainerbtns, .add_btnASB").fadeOut(150);
    $(".Backbtnskuid1, .StockBatchContainer, .StockBatchContainerbtns, .skuid1Container").fadeIn(300);

    });

    $(".Updatebtnskuid2, .Backbtnskuid2").click(function () {
    document.title = "Stock Controller - Product Information";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle4").removeClass("Bold").addClass("Normal");
    $(".subtitle5").removeClass("Bold").addClass("Normal");
    $(".subtitle8").removeClass("Bold").addClass("Normal");
    $(".subtitle7").removeClass("Bold").addClass("Normal");
    $(".subtitle6").removeClass("Bold").addClass("Normal").fadeOut(200);

    $(".skuid1Container, .Removebtnskuid1, .Updatebtnskuid1, .Backbtnskuid1").fadeIn(150);
    $(".UpdateProdInfoContainer, .Backbtnskuid2, .Updatebtnskuid2, .Backbtnskuid2").fadeOut(300);

    });

    $(".cancel_btn, .add_btn, .Removebtnskuid1, .Backbtnskuid1").click(function () {

    document.title = "Stock Controller - Inventory";

    $(".addProductContainer, .cancel_btn, .add_btn, .PullOutLogGroup").fadeOut(150);
    $(".skuid1Container, .Updatebtnskuid1, .Removebtnskuid1, .Backbtnskuid1").fadeOut(150);

    $(".StockBatch, .PullOutLog").removeClass("active");
    $(".ProdInfo").addClass("active");

    $(".TireTbl, .trackinventorypage, .addProductBtn").fadeIn(300);

    $(".subtitle3").removeClass("Normal").addClass("Bold");
    $(".subtitle4, .subtitle5").removeClass("Bold").fadeOut(200);

    $(".inventory").attr("src", "assets/inventory3.png");
    });

    $(".RemovebtnBattskuid1, .BackbtnBattskuid1").click(function () {

    document.title = "Stock Controller - Inventory";

    $(".addProductContainer, .cancel_btn, .add_btn, .PullOutLogGroup, .BattProductInfoContainerbtns, .BatterySKU1Container").fadeOut(150);
    $(".skuid1Container, .Updatebtnskuid1, .Removebtnskuid1, .Backbtnskuid1").fadeOut(150);

    $(".StockBatch, .PullOutLog").removeClass("active");
    $(".ProdInfo").addClass("active");

    $(".TireTbl, .trackinventorypage, .addProductBtn").fadeIn(300);

    $(".subtitle3").removeClass("Normal").addClass("Bold");
    $(".subtitle4, .subtitle5").removeClass("Bold").fadeOut(200);

    $(".TrashGroup, .RimsGroup, .TiresGroup").fadeOut(150);
    $(".BatteryGroup").fadeIn(300);

    $(".inventory").attr("src", "assets/inventory3.png");
    });

    /* ================= PRODUCT INFO ================= */
    $(".BATSKU1").click(function (e) {
    e.preventDefault();

    document.title = "Stock Controller Portal - Product Information";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle5").addClass("Bold").fadeIn(200);

    $(".StockBatch, .PullOutLog").removeClass("active");
    $(".ProdInfo").addClass("active");

    $(".trackinventorypage, .addProductBtn, .StockBatchContainer, .StockBatchContainerbtns").fadeOut(150);
    $(".TrashGroup, .RimsGroup, .BatteryGroup, .TiresGroup").fadeOut(150);
    $(".BattProductInfoContainerbtns, .BatterySKU1Container").fadeIn(300);

    $(".inventory").attr("src", "assets/inventory2.png");
    });

    $(".skuid1").click(function (e) {
    e.preventDefault();

    document.title = "Stock Controller Portal - Product Information";

    $(".subtitle3").removeClass("Bold").addClass("Normal");
    $(".subtitle5").addClass("Bold").fadeIn(200);

    $(".StockBatch, .PullOutLog").removeClass("active");
    $(".ProdInfo").addClass("active");

    $(".trackinventorypage, .addProductBtn, .StockBatchContainer, .StockBatchContainerbtns").fadeOut(150);
    $(".Updatebtnskuid1, .Removebtnskuid1, .Backbtnskuid1, .skuid1Container, .ProductInfoContainer, .ProductInfoContainerbtns").fadeIn(300);

    $(".inventory").attr("src", "assets/inventory2.png");
    });


    /******************************************************/


    $(".skuid1Img, .skuid1Settings").click(function (e) {
    e.preventDefault();

    $(".blackbg, .ProductInfoImgEditContainer").fadeIn(300);
    });

    $(".blackbg").click(function (e) {
    e.preventDefault();

    $(".blackbg, .ProductInfoImgEditContainer").fadeOut(300);
    });

    $(".Batteryskuid1Img, .Batteryskuid1Settings").click(function (e) {
    e.preventDefault();

    $(".blackbg, .BatteryProductInfoImgEditContainer").fadeIn(300);
    });

    $(".blackbg").click(function (e) {
    e.preventDefault();

    $(".blackbg, .ProductInfoImgEditContainer, .BatteryProductInfoImgEditContainer").fadeOut(300);
    });

    /* ================= STATUS ================= */
    setTimeout(function () {
    $(".status").addClass("status_loaded");
    }, 800);
});
   
/**************************************************************/
$(".TiresTab").click(function () {
        $(".TrashGroup, .RimsGroup, .BatteryGroup").fadeOut(150);
        $(".TiresGroup").fadeIn(300);

        $(".BatteryTab, .TrashTab, .RimsTab").removeClass("active");
        $(".TiresTab").addClass("active");
        });

$(".TrashTab").click(function () {
        $(".TiresGroup, .RimsGroup, .BatteryGroup").fadeOut(150);
        $(".TrashGroup").fadeIn(300);

        $(".BatteryTab, .TiresTab, .RimsTab").removeClass("active");
        $(".TrashTab").addClass("active");
        });

$(".BatteryTab").click(function () {
        $(".TiresGroup, .RimsGroup, .TrashGroup").fadeOut(150);
        $(".BatteryGroup").fadeIn(300);

        $(".TrashTab, .TiresTab, .RimsTab").removeClass("active");
        $(".BatteryTab").addClass("active");
        });

$(".RimsTab").click(function () {
        $(".TiresGroup, .BatteryGroup, .TrashGroup").fadeOut(150);
        $(".RimsGroup").fadeIn(300);

        $(".TrashTab, .TiresTab, .BatteryTab").removeClass("active");
        $(".RimsTab").addClass("active");
        });