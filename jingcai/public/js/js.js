$(window).resize(function() {
    var wheight = $(window).height();
    $(".indexbox").height(wheight);
});

$(document).ready(function () {
    var wheight = $(window).height();
    $(".indexbox").height(wheight);





    $(".cgj_box_ul_li_ul_li").click(function () {
        $(this).children(".cgj_box_ul_li_ul_li_h2").addClass("on").parents().siblings().children(".cgj_box_ul_li_ul_li_h2").removeClass("on");
        $(this).parents().parents().siblings().children(".cgj_box_ul_li_ul").children().siblings().children(".cgj_box_ul_li_ul_li_h2").removeClass("on");
    })
})



