function getmetaContents(mn){
      var m = document.getElementsByTagName('meta');
      for(var i in m){
       if(m[i].name == mn){
         return m[i].content;
        }
    }
}

bk_addPageCtx('keywords', getmetaContents('keywords'));
bk_doJSTag(2939, 4);