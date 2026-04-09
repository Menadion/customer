* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #f3f3f3;
    color: #1e1e1e;
}

.container {
    display: flex;
    min-height: 100vh;
    width: 100%;
}

.sidebar {
    width: 185px;
    background: #024b4d;
    padding: 30px 18px;
    display: flex;
    align-items: flex-start;
}

.menu {
    width: 100%;
    margin-top: 85px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 14px;
    color: #ffffff;
    text-decoration: none;
    padding: 14px 10px;
    border-radius: 10px;
    margin-bottom: 12px;
    font-size: 14px;
    transition: 0.2s ease;
}

.nav-item i {
    font-size: 22px;
    width: 22px;
    text-align: center;
}

.nav-item:hover,
.nav-item.active {
    background: rgba(255, 255, 255, 0.10);
}

.main-content {
    flex: 1;
    width: calc(100vw - 185px);
    padding: 22px;
    background: #f5f5f5;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.topbar h2 {
    font-size: 20px;
    font-weight: 500;
    color: #111;
}

.top-icons {
    display: flex;
    align-items: center;
    gap: 14px;
}

.icon-btn {
    border: none;
    background: transparent;
    cursor: pointer;
}

.icon-btn i {
    font-size: 34px;
    color: #024b4d;
}

.profile-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: none;
    background: #d9d9d9;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.profile-btn i {
    font-size: 18px;
    color: #666;
}

hr {
    margin: 8px 0 26px;
    border: none;
    border-top: 1px solid #999;
}

.filter-section {
    margin-bottom: 24px;
    width: 100%;
}

.filter-btn {
    border: 1px solid #c6c6c6;
    background: #fff;
    border-radius: 8px;
    padding: 10px 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
}

.filter-btn i {
    color: #333;
}

.date-filter-box {
    margin-top: 14px;
    display: flex;
    align-items: end;
    gap: 16px;
    flex-wrap: wrap;
    background: #fff;
    border: 1px solid #d5d5d5;
    border-radius: 12px;
    padding: 16px;
    max-width: 520px;
}

.hidden {
    display: none;
}

.date-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.date-group label {
    font-size: 14px;
    color: #333;
}

.date-group input {
    width: 180px;
    height: 40px;
    border: 1px solid #cfcfcf;
    border-radius: 8px;
    padding: 0 10px;
    font-size: 14px;
    outline: none;
}

.apply-btn {
    height: 40px;
    padding: 0 18px;
    border: none;
    border-radius: 8px;
    background: #024b4d;
    color: #fff;
    cursor: pointer;
    font-size: 14px;
}

.history-card {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    box-shadow: 3px 5px 10px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    min-height: 420px;
}

.history-header {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    background: #d7d7d7;
    color: #024b4d;
    font-size: 16px;
    font-weight: 700;
    padding: 16px 24px;
    text-align: center;
}

.empty-history {
    min-height: 330px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 10px;
    text-align: center;
    padding: 20px;
}

.empty-history i {
    font-size: 46px;
    color: #8b8b8b;
    margin-bottom: 4px;
}

.empty-history h3 {
    font-size: 24px;
    color: #333;
}

.empty-history p {
    font-size: 15px;
    color: #777;
    max-width: 420px;
}

@media (max-width: 900px) {
    .date-filter-box {
        flex-direction: column;
        align-items: stretch;
    }

    .date-group input {
        width: 100%;
    }

    .history-header {
        grid-template-columns: 1fr 1fr 1fr;
        font-size: 14px;
        padding: 14px 12px;
    }
}

.notification-wrapper {
    position: relative;
}

.notification-box {
    position: absolute;
    top: 46px;
    right: 0;
    width: 260px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    padding: 15px;
    z-index: 1000;
}

.notification-box h4 {
    margin-bottom: 10px;
    font-size: 16px;
    color: #024b4d;
}

.notification-empty {
    font-size: 14px;
    color: #777;
    text-align: center;
    padding: 15px 0;
}

.hidden {
    display: none;
}

.top-profile-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.profile-btn {
    text-decoration: none;
    overflow: hidden;
}

.profile-dropdown {
    position: relative;
    cursor: pointer;
}

.profile-menu {
    position: absolute;
    right: 0;
    top: 50px;
    background: white;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    width: 140px;
    display: flex;
    flex-direction: column;
}

.profile-menu a {
    padding: 10px 14px;
    text-decoration: none;
    color: #333;
}

.profile-menu a:hover {
    background: #f3f3f3;
}

.hidden {
     display: none !important;
}

.history-header-wide,
.history-row-wide {
    display: grid;
    grid-template-columns: 1.8fr 1fr 0.7fr;
    gap: 12px;
    align-items: center;
    text-align: center;
}
.history-row-wide {
    padding: 16px 24px;
    border-bottom: 1px solid #e0e0e0;
    font-size: 14px;
    background: #fff;
}

.history-row-wide > div {
    word-break: break-word;
    line-height: 1.5;
}

@media (max-width: 1100px) {
    .history-header-wide,
    .history-row-wide {
        grid-template-columns: 1fr;
        text-align: left;
    }

    .history-header-wide {
        display: none;
    }

    .history-row-wide {
        border-bottom: 1px solid #dcdcdc;
        padding: 18px;
    }

    .history-row-wide > div::before {
        display: block;
        font-weight: 700;
        color: #024b4d;
        margin-bottom: 4px;
    }

    .history-row-wide > div:nth-child(1)::before { content: "Date"; }
    .history-row-wide > div:nth-child(2)::before { content: "Price"; }
    .history-row-wide > div:nth-child(3)::before { content: "Payment"; }
    .history-row-wide > div:nth-child(4)::before { content: "Services"; }
    .history-row-wide > div:nth-child(5)::before { content: "Items Used"; }
}

.history-header-wide > div,
.history-row-wide > div {
    display: flex;
    align-items: center;
    justify-content: center;
}

.history-row-wide {
    padding: 16px 24px;
    border-bottom: 1px solid #e0e0e0;
    font-size: 14px;
    background: #fff;
    min-height: 64px;
}

.history-row-wide > div {
    word-break: break-word;
    line-height: 1.5;
}

.receipt-btn {
    border: none;
    background: #024b4d;
    color: #fff;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
}

.receipt-btn:hover {
    background: #01393b;
}

.receipt-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1200;
    padding: 20px;
}

.receipt-modal {
    width: 100%;
    max-width: 620px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.20);
    overflow: hidden;
}

.receipt-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 22px;
    border-bottom: 1px solid #e5e5e5;
}

.receipt-modal-header h3 {
    font-size: 22px;
    color: #024b4d;
}

.close-receipt-btn {
    border: none;
    background: transparent;
    font-size: 22px;
    cursor: pointer;
    color: #333;
}

.receipt-body {
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.receipt-line {
    font-size: 15px;
    line-height: 1.6;
}

.receipt-total {
    margin-top: 8px;
    padding-top: 14px;
    border-top: 1px solid #e5e5e5;
    font-size: 17px;
    color: #024b4d;
}

@media (max-width: 1100px) {
    .history-header-wide,
    .history-row-wide {
        grid-template-columns: 1fr;
        text-align: left;
    }

    .history-header-wide {
        display: none;
    }

    .history-row-wide > div::before {
        display: block;
        font-weight: 700;
        color: #024b4d;
        margin-bottom: 4px;
    }

    .history-row-wide > div:nth-child(1)::before { content: "Date"; }
    .history-row-wide > div:nth-child(2)::before { content: "Price"; }
    .history-row-wide > div:nth-child(3)::before { content: "Payment"; }
    .history-row-wide > div:nth-child(4)::before { content: "Services"; }
    .history-row-wide > div:nth-child(5)::before { content: "Items Used"; }
    .history-row-wide > div:nth-child(6)::before { content: "Receipt"; }
}

.history-header-wide > div,
.history-row-wide > div {
    display: flex;
    align-items: center;
    justify-content: center;
}

.receipt-btn {
    min-width: 70px;
    height: 32px;
    padding: 0 14px;
    border: none;
    background: #024b4d;
    color: #fff;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
}

.history-card {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    box-shadow: 3px 5px 10px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    min-height: 220px;
}