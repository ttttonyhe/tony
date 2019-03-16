    function setCookie(name,value){ 
        var Days = 30; 
        var exp = new Date(); 
        exp.setTime(exp.getTime() + Days*24*60*60*1000); 
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
        location.reload();
    }
    
    function getCookie(name){ 
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
            return unescape(arr[2]); 
        else 
            return null; 
    } 

    function delCookie(name){ 
        var exp = new Date(); 
        exp.setTime(exp.getTime() - 1); 
        var cval=getCookie(name); 
        if(cval!=null) 
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
        location.reload();
    }

    $(window).scroll(function() {
        var to_top_header = $(document).scrollTop();
        if (to_top_header <= 0) {
            $('#header-div').attr('class','tony-header-fixed');
            $('#view-div').css('display','none');
            
            $('#header-div').hover(function(){
            $('#header-div').attr('class','tony-header-scoll');
            },function(){
            $('#header-div').attr('class','tony-header-fixed');
            })
            
        }else{
            $('#header-div').attr('class','tony-header-scoll');
            $('#view-div').css('display','block');
            
            $('#header-div').hover(function(){
            $('#header-div').attr('class','tony-header-scoll');
            },function(){
            $('#header-div').attr('class','tony-header-scoll');
            })
        }
      });
      
      var open_search = function(){
          $('#search_form').attr('class','search_form_play');
          $('.search-bg-b').attr('style','display:block');
          $('#search-div').attr('style','display:block');
      }
      var close_search = function(){
          $('#search_form').attr('class','search_form_dis');
          $('.search-bg-b').attr('style','display:none');
          $('#search-div').attr('style','display:none');
      }