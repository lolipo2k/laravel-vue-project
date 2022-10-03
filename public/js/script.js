document.addEventListener('DOMContentLoaded', function(){
    const windowInnerWidth = window.innerWidth;
    console.log(windowInnerWidth);



    if(windowInnerWidth < 1250 && windowInnerWidth > 500){
        let percent = windowInnerWidth/1250;
        //var list = document.getElementsByTagName("html").style.fontSize = percent+'px';
        var list = document.getElementById("id01").style.fontSize = percent+'px';
        console.log(list)
       // list.style.fontSize = percent+'px';
        console.log(percent);
    }
    if( windowInnerWidth < 500){
        var list = document.getElementById("id01").style.fontSize = '0.6px';
    }
});
