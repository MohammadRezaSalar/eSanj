function error_toastr(message){
    toastr.error(message, "پیغام خطا", {
        positionClass: "toast-top-left",
        timeOut: 10e3,
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: false
    })
}
function success_toastr(message){
    toastr.success(message, "پیغام سیستم", {
        positionClass: "toast-top-left",
        timeOut: 4e3,
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: false
    })
}
function info_toastr(message){
    toastr.info(message, "پیغام سیستم", {
        positionClass: "toast-top-left",
        timeOut: 4e3,
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: false
    })
}
function makeItTwoDigits(number){
    if (number.toString().length==1){
        return '0'+number
    }else{
        return number;
    }
}
function get_just_current_date(){
    var ndt=new Date();
    var g_y=ndt.getFullYear();
    var g_m=ndt.getMonth()+1;
    var g_d=ndt.getDate();
    var shamsi=gregorian_to_jalali(g_y,g_m,g_d);
    var date=makeItTwoDigits(shamsi[0])+'/'+makeItTwoDigits(shamsi[1])+'/'+makeItTwoDigits(shamsi[2]);
    return date.toString()
}
function scrollToElement(element,delay){
    $([document.documentElement, document.body]).animate({
        scrollTop: element.offset().top
    }, delay);
}
function removeInvalidErrorsInBox(box){
    box.find('.invalid-feedback').remove();
    box.find('.is-invalid').removeClass('is-invalid');
}
//  ------- START     make page loading and not access able      START    --------
function showPreloader(){
    $('#my-preloader').css('display','block')
}
function removePreloader(){
    $('#my-preloader').css('display','none')
}
// ------ END      make page loading and not access able     END  ---------------


function makeButtonLoading(button){
    button.attr('old_text',button.text());
    button.prop('disabled',true)
    button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
}

$('.modal').attr('data-keyboard','false');
$('.modal').attr('data-backdrop','static');


function removeLoadingFromButton(button){
    button.html(button.attr('old_text'));
    button.prop('disabled',false);
}


function ajax_header(){
    return $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':document.head.querySelector('meta[name="csrf-token"]').content,
            // 'Content-Type':'application/json'
        }
    })
}


// ------------------  validation inputs
function validateInput(input,rules){
    var isValid=true;
    var inputTextLength=input.val() ? input.val().trim().length : 0;
    var requiredRule='required' in rules && rules.required && inputTextLength==0;
    var canEmptyRule=!('required' in rules) || ('required' in rules && !rules.required);
    var canEmptyAndItIsEmpty=canEmptyRule && inputTextLength==0;
    var isMoney='isMoney' in rules && rules.isMoney;

    if(requiredRule){
        var error=`فیلد ${getInputName(input)} نمی تواند خالی باشد.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if('minLength' in rules && inputTextLength < rules.minLength && !requiredRule && !canEmptyAndItIsEmpty ){
        var error=`طول فیلد ${getInputName(input)} نمی تواند کمتر از ${rules.minLength} حرف باشد.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if('maxLength' in rules && inputTextLength > rules.maxLength && !requiredRule && !canEmptyAndItIsEmpty ){
        var error=`طول فیلد ${getInputName(input)} نمی تواند بیشتر از ${rules.maxLength} حرف باشد.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if('minValue' in rules && ToNumber(input.val()) < rules.minValue && !requiredRule && !canEmptyAndItIsEmpty ){
        var error=`مقدار فیلد ${getInputName(input)} نمی تواند کمتر از ${rules.minValue}  باشد.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if('maxValue' in rules && ToNumber(input.val()) > rules.maxValue && !requiredRule && !canEmptyAndItIsEmpty ){
        var error=`مقدار فیلد ${getInputName(input)} نمی تواند بیشتر از ${rules.maxValue}  باشد.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if('length' in rules && inputTextLength!=rules.length && !requiredRule && !canEmptyAndItIsEmpty){
        var error=` فیلد ${getInputName(input)} باید دقیقا ${rules.length} کاراکتر باشد.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if(isMoney && !$.isNumeric(ToNumber(input.val().trim()))){
        var error=`فیلد ${getInputName(input)} را تنها با عدد پر کنید.`;
        addInputRuleError(input,error);
        isValid=false;
    }else if(!isMoney &&'numeric' in rules && rules.numeric && !$.isNumeric(input.val().trim()) && !requiredRule && !canEmptyAndItIsEmpty ){
        var error=`فیلد ${getInputName(input)} را تنها با عدد پر کنید.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if('email' in rules && rules.email && !isEmail(input.val().trim()) && !canEmptyAndItIsEmpty ){
        var error=`فیلد ${getInputName(input)} با فرمت نامناسب وارد شده است.`;
        addInputRuleError(input,error);
        isValid=false;
    }
    if('optionValueBlocked' in rules && rules.optionValueBlocked==input.find('option:selected').val()){
        if (rules.selectBoxNormal){
            var name=input.siblings('label').text();
            var error=` ${name} انتخاب شده نا معتبر می باشد.`;
            addInputRuleErrorForOptions(input,error,true);
        }else {
            var name=input.parent().siblings('label').text();
            var error=` ${name} انتخاب شده نا معتبر می باشد.`;
            addInputRuleErrorForOptions(input,error,false);
        }
        isValid=false;
    }
    return isValid;
}

function addInputRuleError(input,error){
    input.removeClass('is-invalid').addClass('is-invalid')
    input.after(`
        <span class="invalid-feedback" role="alert">
            <strong>${error}</strong>
        </span>
        `);
}

function addInputRuleErrorForOptions(input,error,is_normal){
    if(is_normal){
        input.removeClass('is-invalid').addClass('is-invalid')
        input.after(`
        <span class="invalid-feedback" role="alert" style="display: block">
            <strong>${error}</strong>
        </span>
        `);
    }else {
        input.next().removeClass('is-invalid').addClass('is-invalid')
        input.next().after(`
        <span class="invalid-feedback" role="alert" style="display: block">
            <strong>${error}</strong>
        </span>
        `);
    }
}


function getInputName(input){
    return input.siblings('label').text();
}


