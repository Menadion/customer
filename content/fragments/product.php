<div class="INVENTORY">
    <div class="trackinventorypage">
        <div class="TireTbl">
        <div class="tab-container">
        <div class="tab active TiresTab">Tires</div>
        <div class="tab BatteryTab">Battery</div>
        <div class="tab RimsTab">Rims</div>
    </div>

    <div class="filter-bar TiresGroup">
        <select class="filter-select">	
            <option selected disabled>Brand</option>
            <option>All</option>
            <option>Bridgestone</option>
            <option>Nankang</option>
            <option>Goodyear</option>
            <option>Yokohama</option>
            <option>Westlake</option>
        </select>

        <select class="filter-select TiresGroup">
            <option selected disabled>Size</option>
            <option>All</option>
            <option>173-13</option>
            <option>165-60-13</option>
            <option>185-60-14</option>
            <option>185-14</option>
            <option>11R22.5</option>
        </select>

        <div class="search-wrapper">
            <input type="text" placeholder="Search">
            <span class="search-icon">
            <img src="<?= ROOT_URL ?>assets/Search.svg" alt="Search">
            </span>
        </div>
    </div>

    <div class="table-card">
        <table class="inventorytables TiresGroup">
            <thead class="inventoryhead">
            <tr>
                <th class="inventoryth">SKU</th>
                <th class="inventoryth">BRAND <span class="sort">↑↓</span></th>
                <th class="inventoryth">SIZE <span class="sort">↑↓</span></th>
                <th class="inventoryth">PRICE <span class="sort">↑↓</span></th>
                <th class="inventoryth">STOCK <span class="sort">↑↓</span></th>
                <th class="inventoryth">IMAGE</th>
                <th class="inventoryth">STATUS <span class="sort">↑↓</span></th>
            </tr>
            </thead>

            <tbody class="inventorybody">
                <tr class="inventorytr">
                    <td class="inventorytd skuid1"><a href="#">TIR-NAN-17313</a></td>
                    <td class="BRAND inventorytd">NANKANG</td>
                    <td class="inventorytd">173-13</td>
                    <td class="inventorytd">Php 1,700</td>
                    <td class="inventorytd">10</td>
                    <td class="inventorytd imageproduct">
                    <img src="assets/nankang2.png" alt="Nankang Tire">
                </td>
                <td class="inventorytd">
                    <span class="badge green">IN STOCK</span>
                </td>
            </tr>

            <tr class="inventorytr">
                <td class="inventorytd skuid2"><a href="#">TIR-WES-1656013</a></td>
                <td class="BRAND inventorytd">WESTLAKE</td>
                <td class="inventorytd">165-60-13</td>
                <td class="inventorytd">Php 2,100</td>
                <td class="inventorytd">0</td>
                <td class="inventorytd imageproduct">
                <img src="assets/westlake.png" alt="Westlake Tire">
                </td>
                <td class="inventorytd">
                <span class="badge red">NO STOCK</span>
                </td>
            </tr>

            <tr class="inventorytr">
                <td class="inventorytd"><a href="#">TIR-YOK-1856014</a></td>
                <td class="BRAND inventorytd">YOKOHAMA</td>
                <td class="inventorytd">185-60-14</td>
                <td class="inventorytd">Php 3,600</td>
                <td class="inventorytd">4</td>
                <td class="inventorytd imageproduct">
                <img src="assets/yokohama.png" alt="Yokohama Tire">
                </td>
                <td class="inventorytd">
                <span class="badge green">IN STOCK</span>
                </td>
            </tr>

            <tr class="inventorytr">
                <td class="inventorytd"><a href="#">TIR-BRI-18514</a></td>
                <td class="BRAND inventorytd">BRIDGESTONE</td>
                <td class="inventorytd">185-14</td>
                <td class="inventorytd">Php 4,800</td>
                <td class="inventorytd">9</td>
                <td class="inventorytd imageproduct">
                <img src="assets/bridgestone.png" alt="Bridgestone Tire">
                </td>
                <td class="inventorytd">
                <span class="badge blue">HIGH STOCK</span>
                </td>
            </tr>

            </tbody>
        </table>

        <div class="pagination">
            <span class="previous disabled">Previous</span>
            <span class="page active">1</span>
            <span class="page">2</span>
            <span class="page">3</span>
            <span class="next">Next</span>
        </div>
        </div>
        </div>
    </div>

    <div class="skuid1Container">
        <div class="skuid1tab-container">
            <div class="skuid1tab ProdInfo active">Product Info</div>
            <div class="skuid1tab StockBatch">Stock Batch</div>
            <div class="skuid1tab PullOutLog">Pull Out Log</div>
        </div>

    <div class="ProductInfoContainer">
        <div class="skuid1Box1"> 	
            <img class="skuid1Img" src="assets/nankang.png" alt="Nankang Tire">
            <span class="badge green skuid1badge">IN STOCK</span>
            <div class="line10"></div>
            <p class="CurrentStockskuid1">Current Stock:</p>
            <p class="CurrentStockCountskuid1"></p>
            <img class="skuid1Settings" src="assets/settings.png" alt="settings_icon">
        </div>

        <div class="ProductInfoImgEditContainer">
            <img class="ProductInfoImgEditskuid1Img" src="assets/nankang.png" alt="Nankang Tire">
            <div class="dragimgContainer">
                <p class="messgeindragimgcontainer"><strong>Drag and drop</strong> <BR></BR> to upload your photo (max 2 MB) </p>
                <div class="messgeindragimgcontainerbtn">choose an image to upload</div>
            </div>
        </div>

        <div class="skuid1Box2"> 
                <table class="product-specs-table">
                    <tr>
                        <td class="spec-label">PRODUCT NAME</td>
                        <td class="spec-value">NANKANG 173-13</td>
                    </tr>
                    <tr>
                        <td class="spec-label">SKU</td>
                        <td class="spec-value">TIR-NAN-17313</td>
                    </tr>
                    <tr>
                        <td class="spec-label">TYPE</td>
                        <td class="spec-value">TIRE</td>
                    </tr>
                    <tr>
                        <td class="spec-label">BRAND</td>
                        <td class="spec-value">NANKANG</td>
                    </tr>
                    <tr>
                        <td class="spec-label">SIZE</td>
                        <td class="spec-value">173-13</td>
                    </tr>
                    <tr>
                        <td class="spec-label">WARRANTY</td>
                        <td class="spec-value">4 YEARS</td>
                    </tr>
                    <tr>
                        <td class="spec-label">PRICE PER UNIT</td>
                        <td class="spec-value spec-price">PHP 1,700</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="StockBatchContainer">
            <div class="page-wrapper-container">
                <div class="stock-table-card">
                    <div class="search-bar-wrapper">
                        <input
                            type="text"
                            class="search-input-field"
                            placeholder="Search"
                        />
                    </div>

                    <table class="inventory-table-element">
                        <thead>
                            <tr class="table-header-row">
                                <th class="header-cell-batch">
                                    BATCH #
                                    <span class="sort-icon-indicator">↑↓</span>
                                </th>
                                <th class="header-cell-quantity">
                                    QUANTITY
                                    <span class="sort-icon-indicator">↑↓</span>
                                </th>
                                <th class="header-cell-manufactured">
                                    MANUFACTURED DATE
                                    <span class="sort-icon-indicator">↑↓</span>
                                </th>
                                <th class="header-cell-expiry">
                                    EXPIRY DATE
                                    <span class="sort-icon-indicator">↑↓</span>
                                </th>
                                <th class="header-cell-received">
                                    DATE RECEIVED
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="data-row-entry">
                                <td class="data-cell-batch">
                                    <a href="#" class="batch-link-anchor BNumIdASB">BATCH-NAN-001</a>
                                </td>
                                <td class="data-cell-quantity">6</td>
                                <td class="data-cell-manufactured">2024-10-15</td>
                                <td class="data-cell-expiry">2029-10-15</td>
                                <td class="data-cell-received">2023-10-20</td>
                            </tr>

                            <tr class="empty-row-spacer"></tr>
                            <tr class="empty-row-spacer"></tr>
                        </tbody>
                    </table>

                    <div class="table-footer-summary">
                        <span class="total-stock-label">TOTAL STOCK: 6 units</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="PullOutLogGroup">
            <div class="PullOutLogContainer">
                <div class="page-wrapper-container">
                    <div class="stock-table-card">

                        <div class="search-bar-wrapper">
                            <input
                                type="text"
                                class="search-input-field"
                                placeholder="Search"
                            />
                        </div>

                        <table class="inventory-table-element">
                            <thead>
                                <tr class="table-header-row">
                                    <th class="header-cell-batch">
                                        BATCH USED
                                        <span class="sort-icon-indicator">↑↓</span>
                                    </th>
                                    <th class="header-cell-quantity">
                                        QUANTITY
                                        <span class="sort-icon-indicator">↑↓</span>
                                    </th>
                                    <th class="header-cell-manufactured">
                                        DATE PULLED
                                        <span class="sort-icon-indicator">↑↓</span>
                                    </th>
                                    <th class="header-cell-expiry">
                                        INVOICE ID
                                        <span class="sort-icon-indicator">↑↓</span>
                                    </th>
                                    <th class="header-cell-received">
                                        ACTION
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="data-row-entry">
                                    <td class="data-cell-batch">
                                        <a href="#" class="batch-link-anchor BNumIdASB">BATCH-NAN-001</a>
                                    </td>
                                    <td class="data-cell-quantity">6</td>
                                    <td class="data-cell-datepulled">5/23/2025</td>
                                    <td class="data-cell-invoice">INV-20250523</td>
                                    <td class="data-cell-action"><img class="deleteicon" src="assets\delete.png" alt=".JPG" height="100%" width="100%"></td>
                                </tr>

                                <tr class="empty-row-spacer"></tr>
                                <tr class="empty-row-spacer"></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="Updatebtnskuid1 ProductInfoContainerbtns">Update</div>
    <div class="Removebtnskuid1 ProductInfoContainerbtns">Remove</div>
    <div class="Backbtnskuid1">Back</div>

    <div class="UpdatebtnBattskuid1 BattProductInfoContainerbtns">Update</div>
    <div class="RemovebtnBattskuid1 BattProductInfoContainerbtns">Remove</div>
    <div class="BackbtnBattskuid1 BattProductInfoContainerbtns">Back</div>

    <div class="AddStockbtnskuid1 StockBatchContainerbtns">Add stock</div>

    <div class="UpdateProdInfoContainer">
        <p class="UpdateProdInfoTitle">UPDATE PRODUCT</p>
        <div class="line6"></div>

        <label for="Product Name" class="PNameUPI">Product name</label>
        <input type="text" class="PNameInputUPI" name="Product Name">

        <label for="SKU" class="SKUUPI">SKU</label>
        <input type="text" class="SKUInputUPI" name="SKU">

        <label for="BRAND" class="BRANDUPI">Brand</label>
        <input type="text" class="BrandInputUPI" name="BRand">

        <label for="Type" class="TypeUPI">Type</label>
        <input type="text" class="TypeInputUPI" name="Type">

        <label for="Size" class="SizeUPI">Size</label>
        <input type="text" class="SizeInputUPI" name="Size">

        <label for="Warranty" class="WarrantyUPI">Warranty</label>
        <input type="text" class="WarrantyInputUPI" name="Warranty">

        <label for="Price Per Unit" class="PricePerUnitUPI">Price Per Unit</label>
        <input type="text" class="PricePerUnitInputUPI" name="Price Per Unit">
    </div>

    <div class="AddStockBatchContainer">
        <p class="AddStockBatchTitle">ADD NEW STOCK</p>
        <div class="line6"></div>

        <label for="Batch Number" class="BNumASB">Batch Number</label>
        <input type="text" class="BNumInputASB" name="Batch Number">

        <label for="Quantity" class="QuantityASB">Quantity</label>
        <input type="text" class="QuantityInputASB" name="Quantity">

        <label for="DATE RECEIVED" class="DateRecievedASB">DATE RECEIVED</label>
        <input type="text" class="DateRecievedInputASB" name="DATE RECEIVED">

        <label for="ManufacutingDate" class="ManufacutingDateASB">MANUFACTURING DATE</label>
        <input type="text" class="ManufacutingDateInputASB" name="ManufacutingDateASB">

        <label for="ExpiryDate" class="ExpiryDateASB">EXPIRY DATE</label>
        <input type="text" class="ExpiryDateInputASB" name="ExpiryDate">

        <label for="SUPPLIER" class="SUPPLIERASB">SUPPLIER</label>
        <input type="text" class="SUPPLIERInputASB" name="SUPPLIER">
    </div>

    <p class="add_btnASB">Add</p>

    <div class="Updatebtnskuid2">Update</div>
    <div class="Backbtnskuid2">Back</div>

    <div class="StockBatchInfoContainer">
        <p class="StockBatchInfoTitle">BATCH-NAN-001</p>
        <div class="line6"></div>

        <label for="QuantityBatchInfo" class="QuantityBatchInfo">Quantity</label>
        <input type="text" class="QuantityInputBatchInfo" name="Quantity">

        <label for="DateRecievedBatchInfo" class="DateRecievedBatchInfo">Date Recieved</label>
        <input type="text" class="DateRecievedInputBatchInfo" name="DateRecievedBatchInfo">

        <label for="ManufacutingDateBatchInfo" class="ManufacutingDateBatchInfo">MANUFACTURING DATE</label>
        <input type="text" class="ManufacutingDateInputBatchInfo" name="ManufacutingDateBatchInfo">

        <label for="ExpiryDateBatchInfo" class="ExpiryDateBatchInfo">EXPIRY DATE</label>
        <input type="text" class="ExpiryDateInputBatchInfo" name="ExpiryDate">

        <label for="SUPPLIERBatchInfo" class="SUPPLIERBatchInfo">SUPPLIER</label>
        <input type="text" class="SUPPLIERInputBatchInfo" name="SUPPLIER">
    </div>

    <div class="UpdatebtnStockBatchInfo StockBatchInfoContainerbtns">Update</div>
    <div class="RemovebtnStockBatchInfo StockBatchInfoContainerbtns">Remove</div>
    <div class="Backbtnskuid1 StockBatchInfoContainerbtns">Back</div>

    <div class="BatteryGroup">
        <div class="filter-bar-BatteryGroup">
            <select class="filter-select">	
                <option selected disabled>Brand</option>
                <option>All</option>
                <option>Motolite</option>
                <option>Amaron</option>
            </select>

            <div class="search-wrapper">
                <input type="text" placeholder="Search">
                <span class="search-icon">
                <img src="<?= ROOT_URL ?>assets/Search.svg" alt="Search">
                </span>
            </div>
        </div>
        <div class="battery-table-card">
            <table class="battery-inventory-table">
            <thead class="battery-table-head">
                <tr>
                <th class="battery-th">SKU</th>
                <th class="battery-th">BRAND <span class="battery-sort">↑↓</span></th>
                <th class="battery-th">PRICE <span class="battery-sort">↑↓</span></th>
                <th class="battery-th">STOCK <span class="battery-sort">↑↓</span></th>
                <th class="battery-th">IMAGE</th>
                <th class="battery-th">STATUS <span class="battery-sort">↑↓</span></th>
                </tr>
            </thead>
                <tbody class="batterytablebody">
                    <tr class="battery-row">
                    <td class="battery-td ">
                        <a href="#" class="BATSKU1">BAT-MOT-NS60</a>
                    </td>
                    <td class="battery-td BRAND">MOTOLITE ENDURO</td>
                    <td class="battery-td">Php 5,250</td>
                    <td class="battery-td">3</td>
                    <td class="battery-td imageproduct" style="text-align: center;">
                        <img src="assets/motolite.png" alt="Motolite Battery">
                    </td>
                    <td class="battery-td">
                        <span class="battery-status badge red">LOW STOCK</span>
                    </td>
                    </tr>

                    <tr class="battery-row">
                    <td class="battery-td battery-sku">
                        <a href="#">BAT-AMA-DIN44</a>
                    </td>
                    <td class="battery-td BRAND">AMARON HI-LIFE</td>
                    <td class="battery-td">Php 5,800</td>
                    <td class="battery-td">0</td>
                    <td class="battery-td imageproduct" style="text-align: center;">
                        <img src="assets/amaron.png" alt="Amaron Battery">
                    </td>
                    <td class="battery-td">
                        <span class="battery-status badge red">NO STOCK</span>
                    </td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
            <span class="previous disabled">Previous</span>
            <span class="page active">1</span>
            <span class="next">Next</span>
            </div>
        </div>
    </div>

    <div class="RimsGroup">
        <div class="filter-bar-RimsGroup">
        <select class="filter-select">	
            <option selected disabled>Brand</option>
            <option>All</option>
            <option>Enkie</option>
            <option>BBS</option>
            <option>Volk Racing</option>
            <option>SSR</option>
            <option>Sparco</option>
        </select>

        <select class="filter-select">
            <option selected disabled>Size</option>
            <option>All</option>
            <option>15" X 16"</option>
            <option>16" X 7"</option>
            <option>17" X 7.5"</option>
            <option>18" X 8"</option>
        </select>

        <div class="search-wrapper">
            <input type="text" placeholder="Search">
            <span class="search-icon">
            <img src="<?= ROOT_URL ?>assets/Search.svg" alt="Search">
            </span>
        </div>
    </div>

    <div class="rim-card">
        <table class="rim-table">
            <thead class="rim-head">
                <tr>
                <th class="rim-th">SKU</th>
                <th class="rim-th">BRAND <span class="rim-sort">↑↓</span></th>
                <th class="rim-th">SIZE <span class="rim-sort">↑↓</span></th>
                <th class="rim-th">PRICE <span class="rim-sort">↑↓</span></th>
                <th class="rim-th">STOCK <span class="rim-sort">↑↓</span></th>
                <th class="rim-th">IMAGE</th>
                <th class="rim-th">STATUS <span class="rim-sort">↑↓</span></th>
                </tr>
            </thead>
            <tbody class="rim-body">
                <tr class="rim-row">
                <td class="rim-td"><a href="#">RIM-ENK-156035</a></td>
                <td class="rim-td BRAND">ENKEI</td>
                <td class="rim-td">15&quot; X 6&quot; ET35</td>
                <td class="rim-td">Php 10,000</td>
                <td class="rim-td">12</td>
                <td class="rim-td imageproduct">
                    <img src="assets/enkei.png" alt="Enkei Rim">
                </td>
                <td class="rim-td">
                    <span class="rim-status badge blue">HIGH STOCK</span>
                </td>
                </tr>

                <tr class="rim-row">
                <td class="rim-td "><a href="#">RIM-BBS-167040</a></td>
                <td class="rim-td BRAND">BBS</td>
                <td class="rim-td">16&quot; X 7&quot; ET40</td>
                <td class="rim-td">Php 18,500</td>
                <td class="rim-td">4</td>
                <td class="rim-td imageproduct">
                    <img src="assets/bbs.png" alt="BBS Rim">
                </td>
                <td class="rim-td">
                    <span class="rim-status badge red">LOW STOCK</span>
                </td>
                </tr>

                <tr class="rim-row">
                <td class="rim-td "><a href="#">RIM-VOL-177538</a></td>
                <td class="rim-td BRAND">VOLK RACING</td>
                <td class="rim-td">17&quot; X 7.5&quot; ET38</td>
                <td class="rim-td">Php 32,500</td>
                <td class="rim-td">0</td>
                <td class="rim-td imageproduct">
                    <img src="assets/volkracing.png" alt="Volk Rim">
                </td>
                <td class="rim-td">
                    <span class="rim-status badge red">NO STOCK</span>
                </td>
                </tr>

                <tr class="rim-row">
                <td class="rim-td "><a href="#">RIM-SSR-188040</a></td>
                <td class="rim-td BRAND">SSR</td>
                <td class="rim-td">18&quot; X 8&quot; ET40</td>
                <td class="rim-td">Php 25,000</td>
                <td class="rim-td">8</td>
                <td class="rim-td imageproduct">
                    <img src="assets/ssr.png" alt="SSR Rim">
                </td>
                <td class="rim-td">
                    <span class="rim-status badge green">IN STOCK</span>
                </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination">
        <span class="previous page-off">Previous</span>
        <span class="page active">1</span>
        <span class="page">2</span>
        <span class="page">3</span>
        <span class="next">Next</span>
    </div>

    <div class="BatterySKU1Container">
    <div class="Batteryskuid1tab-container">
        <div class="Batteryskuid1tab BatteryProdInfo active">Product Info</div>
        <div class="Batteryskuid1tab BatteryStockBatch">Stock Batch</div>
        <div class="Batteryskuid1tab BatteryPullOutLog">Pull Out Log</div>
    </div>
    
    <div class="ProductInfoContainer">
        <div class="Batteryskuid1Box1"> 	
            <img class="Batteryskuid1Img" src="assets/motolite2.png" alt="Nankang Tire">
            <span class="badge red skuid1badge">Low stock</span>
            <div class="line10"></div>
            <p class="BatteryCurrentStockskuid1">Current Stock:</p>
            <p class="BatteryCurrentStockCountskuid1"></p>
            <img class="Batteryskuid1Settings" src="assets/settings.png" alt="settings_icon">
        </div>

        <div class="BatteryProductInfoImgEditContainer">
            <img class="BatteryProductInfoImgEditskuid1Img" src="assets/motolite2.png" alt="Nankang Tire">
            <div class="dragimgContainer">
                <p class="messgeindragimgcontainer"><strong>Drag and drop</strong> <BR></BR> to upload your photo (max 2 MB) </p>
                <div class="messgeindragimgcontainerbtn">choose an image to upload</div>
            </div>
        </div>

        <div class="Batteryskuid1Box2"> 
            <table class="product-specs-table">
                <tr>
                    <td class="spec-label">PRODUCT NAME</td>
                    <td class="spec-value">Motolite Enduro Ns60</td>
                </tr>
                <tr>
                    <td class="spec-label">SKU</td>
                    <td class="spec-value">BAT-MOT-NS60</td>
                </tr>
                <tr>
                    <td class="spec-label">TYPE</td>
                    <td class="spec-value">BATTERY</td>
                </tr>
                <tr>
                    <td class="spec-label">BRAND</td>
                    <td class="spec-value">Motolite</td>
                </tr>
                <tr>
                    <td class="spec-label">SIZE</td>
                    <td class="spec-value">173-13</td>
                </tr>
                <tr>
                    <td class="spec-label">WARRANTY</td>
                    <td class="spec-value">15 MONTHS</td>
                </tr>
                <tr>
                    <td class="spec-label">PRICE PER UNIT</td>
                    <td class="spec-value spec-price">PHP 5,250</td>
                </tr>
            </table>
        </div>
    </div>
</div>