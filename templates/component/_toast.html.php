<?php

/**
 * @var string $type Message Type
 * @var string $message Message Text
 * @var Object $trans Translation object
 */

?>

<div class="toast-container position-fixed d-flex justify-content-center align-items-center p-3" style="position: absolute;left: 50%; transform: translate(-50%, 0px); z-index: 10000">

    <div id="liveToast" class="toast show text-<?=$type?>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header text-bg-primary bg-gradient">
            <strong class="me-auto">Information</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-dark fw-bolder">
            <span><?=$trans->getConfig($message)?></span>
        </div>
    </div>

</div>