<?php $accordeonId = rand() ?>
<div id="accordion_<?php echo $accordeonId; ?>" class="accordion-item">
    <div id="accordionHeader_<?php echo $accordeonId; ?>" class="accordion-header">
        <h3>Chat Link <sub><sup><i>(click here)</i></sup></sub></h3>
        <span class="accordion-icon"></span>
    </div>
    <div id="accordionContent_<?php echo $accordeonId; ?>" class="accordion-content">
        <div class="accordion-content-wrapper">
            <?php include(__DIR__ . '/ChatLinkContent.php'); ?>
        </div>
    </div>
</div>
<script>
    var expanded = false;
    const accordionItem = document.getElementById("accordion_<?php echo $accordeonId; ?>");
    const accordionItemHeader = document.getElementById("accordionHeader_<?php echo $accordeonId; ?>");
    const accordionItemContent = document.getElementById("accordionContent_<?php echo $accordeonId; ?>");
    accordionItemHeader.onclick = function() {
        expanded = !expanded;
        if (expanded && accordionItem) {
            accordionItem.classList.add('active');
        } else if (accordionItem) {
            accordionItem.classList.remove('active');
        }
        if (expanded && accordionItemContent) {
            accordionItemContent.classList.add('active');
        } else if (accordionItemContent) {
            accordionItemContent.classList.remove('active');
        }
    };
</script>