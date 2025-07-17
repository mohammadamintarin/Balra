$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
function actionMoreLess(){
    var boxOuter = ".data_more_less",
        boxInner = ".data_more_less_inner",
        boxBody = ".data_more_less_body",
        showMore = $(".action_more"),
        showLess = $(".action_less");
    $(boxInner).each(function(){
        var $this = $(this),
            bodyDataH = $this.find(boxBody).height();
        $this.css("max-height", $this.data("height"));
        var $thisH = $this.height();
        if(bodyDataH > $thisH){
            $this.closest(boxOuter).removeClass("action_disabled");
        } else {
            $this.closest(boxOuter).addClass("action_disabled");
        }
    })
    showMore.click(function(e){
        e.preventDefault();
        var $this = $(this),
            boxInnerH = $this.closest(boxOuter).find(boxInner).height(),
            boxInnerUpdate = boxInnerH + $this.closest(boxOuter).find(boxInner).data("increase-by"),
            boxBodyH = $this.closest(boxOuter).find(boxBody).height();
        setTimeout(function(){
            if(boxBodyH > boxInnerUpdate){
                $this.closest(boxOuter).removeClass("less_active").find(boxInner).css("max-height", boxInnerUpdate);
            } else {
                $this.closest(boxOuter).addClass("less_active").find(boxInner).css("max-height", "none");
            }
        },10);
    });
    showLess.click(function(){
        $(this).closest(boxOuter).removeClass("less_active").find(boxInner).css("max-height", $(this).closest(boxOuter).find(boxInner).data("height"));
        return false;
    });
} actionMoreLess();
