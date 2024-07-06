$(".detractor").click(function() {
    goDetractor($(this), $(this).attr("id"));
})

$(".detractor").hover(function() {
    goDetractor($(this), $(this).attr("id"));
})

$(".passive").click(function() {
    goPassive($(this), $(this).attr("id"));
})

$(".passive").hover(function() {
    goPassive($(this), $(this).attr("id"));
})

$(".promoter").click(function() {
    goPromoter($(this), $(this).attr("id"));
})

$(".promoter").hover(function() {
    goPromoter($(this), $(this).attr("id"));
})

function goDetractor(thisObj, objectId) {
    thisObj.parent().children().each(function() {
        $(this).removeClass('active-color-passive');
        $(this).removeClass('active-color-promoter');
        $(this).removeClass("active-color-detractor");

        if (parseInt(this.id) <= parseInt(objectId) ) {
            $(this).addClass("active-color-detractor");
        }
    });
    changeScore(objectId);
}

function goPassive(thisObj, objectId) {
    thisObj.parent().children().each(function() {
        $(this).removeClass('active-color-passive');
        $(this).removeClass('active-color-promoter');
        $(this).removeClass("active-color-detractor");

        if (parseInt(this.id) <= parseInt(objectId) ) {
            $(this).addClass("active-color-passive");
        }
    });
    changeScore(objectId);
}


function goPromoter(thisObj, objectId) {
    thisObj.parent().children().each(function() {
        $(this).removeClass('active-color-passive');
        $(this).removeClass('active-color-promoter');
        $(this).removeClass("active-color-detractor");

        if (parseInt(this.id) <= parseInt(objectId) ) {
            $(this).addClass("active-color-promoter");
        }
    });
    changeScore(objectId);
}

function changeScore(value) {
    score = value;
    $("#nps").val(score);
}