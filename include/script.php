<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<script>


jQuery(document).ready(function($){

    // this function will allow to create new keyword form line when activated
    function yydev_create_new_keyword_line() {
        
        $(".wordpress-seo-notes").append("<?php echo $another_keyword_line; ?>");

    } //function yydev_create_new_keyword_line() {

    // remove line when visitor click on the delete button
   $(document).on('click', 'a.remove-seo-data-line', function () {
        $(this).parent().parent().remove();
        
        // if we remove the last keyword line it will create new keyword line
        var KeywordsLineAmount = $(".wordpress-seo-line").length;
        if(KeywordsLineAmount == 0) {
            yydev_create_new_keyword_line();
        } // if(KeywordsLineAmount == 0) {
       
        return false;
    }); // $(document).on('click', 'a.remove-seo-data-line', function () {


    // adding another line whan someone click on Add Another Keyword Line button
    $("a.add-another-seo-data").click(function() {

        // adding another form line to the page
        yydev_create_new_keyword_line();
        return false;

    }); // $(".add-another-seo-data").click(function() {

    // moving the item one position up on the list
    $(document).on('click', 'a.move-keyword-up', function () {

        // adding another form line to the page
        var thisElement = $(this).parent().parent();
        var elementNumber = $(this).parent().parent().index(); // getting the current element number
        var CurrentelementNumber = elementNumber - 1; // reduction because eq() starts from 0
        var NewelementNumber = CurrentelementNumber - 1; // the new element number

        // making sure the elemtn is not the first element
        if(elementNumber != 1) {

            // creating animation that will hide the element and than show it up again
            $("tr.wordpress-seo-line").eq(CurrentelementNumber).animate({opacity: 0}, 100, function() {
                $("tr.wordpress-seo-line").eq(CurrentelementNumber).insertBefore(".wordpress-seo-line:eq(" + NewelementNumber + ")");
                $("tr.wordpress-seo-line").eq(NewelementNumber).animate({opacity: 1}, 500);
            });

            // thisElement.remove();
        } // if(elementNumber != 1) {

        return false;

    }); // $(document).on('click', 'a.move-keyword-up', function () {


    // adding table that will allow to add notes
    $(".add-notes-table-button").click(function() {

        if( $(".add-table-notes").hasClass("hide_textarea") ) {

            // adding another form line to the page
            $(".add-table-notes").removeClass("hide_textarea"); // display the textarea notes
            $(".add-notes-table-button").addClass("hide_textarea_button"); // display the textarea notes
            return false;

        } // if( $(".add-table-notes").hasClass("hide_textarea") ) {

    }); // $(".add-another-seo-data").click(function() {


    // remove the tables with notes
    $("a.remove-table-notes").click(function() {

        $(".add-table-notes").addClass("hide_textarea"); // display the textarea notes
        $(".add-notes-table-button").removeClass("hide_textarea_button"); // display the textarea notes
        $(".add-table-notes textarea").val(""); // setting text area as empty value
        return false;

    }); // $("a.remove-table-notes").click(function() {

    
    // changeing the table direction class (rtl/ltr)
    $(".add-table-notes a.table-text-derction").click(function() {

        var currentDirection = $(".add-table-notes .notes-text-area-direction").val();
        
        // if the current direction is rtl we will change it to ltr
        if(currentDirection === "direction-rtl") {
            $(".add-table-notes .notes-text-area-direction").val("direction-ltr");
            $(".add-table-notes .table_notes").removeClass("direction-rtl")
            $(".add-table-notes .table_notes").addClass("direction-lrt");
        } // if(currentDirection === "direction-rtl") {

        // if the current direction is ltr we will change it to rtl
        if(currentDirection === "direction-ltr") {
            $(".add-table-notes .notes-text-area-direction").val("direction-rtl");
            $(".add-table-notes .table_notes").removeClass("direction-ltr")
            $(".add-table-notes .table_notes").addClass("direction-rtl");
        } // if(currentDirection === "direction-ltr") {

        return false;

    }); // $(".add-another-seo-data").click(function() {


    // delating with adding text separator 
    $(".add-table-notes a.table-line-separator").click(function() {

        // function that helps add a line on the textarea 
        // **textareaClass**.yydevSeoAddSeparator('startCode', endCode)
        jQuery.fn.extend({
            yydevSeoAddSeparator: function(myValue, myValueE) {

                return this.each(function(i) {

                            //For browsers like Firefox and Webkit based
                            var startPos = this.selectionStart;
                            var endPos = this.selectionEnd;
                            var scrollTop = this.scrollTop;
                            this.value = this.value.substring(0,startPos)+myValue+this.value.substring(startPos,endPos)+myValueE+this.value.substring(endPos,this.value.length);
                            this.focus();
                            this.selectionStart = startPos + myValue.length;
                            this.selectionEnd = ((startPos + myValue.length) + this.value.substring(startPos,endPos).length);
                            this.scrollTop = scrollTop;

                    })

            } // return this.each(function(i) {
        }); // jQuery.fn.extend({

        var currentTextArea = $(this).parent().parent().find(".table_notes");
        currentTextArea.yydevSeoAddSeparator("\n\n" + "------------------------------------------------------------------------------------------------------" + "\n\n", '');
        
        return false;

    }); // $(".add-table-notes a.table-line-separator").click(function() {

    // allow to highlight keyword lines
    $(document).on('click', 'input.keywords-checkbox-input', function () {

        var mainTableTr

        if ($(this).is(':checked')) {

            // incase the checkbox was selected
            mainTableTr = $(this).parent().parent();
            mainTableTr.addClass("heightlight-keyword");
            mainTableTr.find(".seo_data_main_keyword_value").val("1");

        } else { // if ($(this).is(':checked')) {

            // incase the checkbox was removed
            mainTableTr = $(this).parent().parent();
            mainTableTr.removeClass("heightlight-keyword");
            mainTableTr.find(".seo_data_main_keyword_value").val("0");

        } // } else { // if ($(this).is(':checked')) {

    }); // $(document).on('click', 'input.keywords-checkbox-input', function () {
    

}); // jQuery(document).ready(function($){

</script>