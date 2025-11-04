<div class="button-wrapper">
    <a href="{{ $addUrl }}" class="df-btn df-add">
        <span class="df-ic" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                <path d="M12 5v14m-7-7h14" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
        Tambah
    </a>

    <a href="{{ $downloadFile }}" class="df-btn df-download">
    <span class="df-ic" aria-hidden="true">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
            <path d="M12 16v-4m0 0l-4 4m4-4l4 4" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
            <path d="M4 4h16v12H4V4z" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </span>
    Unduh
</a>
</div>

<style>
    .button-wrapper {
        display: flex;
        gap: 10px; 
        margin-top: 65px;
        margin-left: 22px;
    }

    .df-btn {
        appearance: none;
        border: 1px solid #d1d5db;
        background: #ffffff;
        padding: 5px 12px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 12px;
        line-height: 1.2;
        text-decoration: none;
        color: #111827;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
        font-weight: 500;
    }

    .df-btn:hover {
        background: #f8fafc;
    }

    .df-btn.df-add .df-ic svg {
        display: block;
        width: 14px;
    }

    .df-btn.df-download .df-ic svg {
        display: block;
        width: 14px;
    }

    .df-ic {
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }
</style>
