
var Share = {
    gplus: function(purl, ptitle, pimg, text){
        url  = 'https://plus.google.com/share?';
        url += 'url='          + encodeURIComponent(purl);
        Share.popup(url);
    },
    vk: function(purl, ptitle, pimg, text) {
        url  = 'http://vkontakte.ru/share.php?';
        url += 'url='          + encodeURIComponent(purl);
        url += '&title='       + encodeURIComponent(ptitle);
        url += '&description=' + encodeURIComponent(text);
        url += '&image='       + encodeURIComponent(pimg);
        url += '&noparse=true';
        Share.popup(url);
    },
    odnoklassniki: function(purl, ptitle, pimg, text) {
        url  = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
        url += '&st.comments=' + encodeURIComponent(text);
        url += '&st._surl='    + encodeURIComponent(purl);
        Share.popup(url);
    },
    fb: function(purl, ptitle, pimg, text) {
        url  = 'http://www.facebook.com/sharer.php?s=100';
        url += '&p[title]='     + encodeURIComponent(ptitle);
        url += '&p[summary]='   + encodeURIComponent(text);
        url += '&p[url]='       + encodeURIComponent(purl);
        url += '&p[images][0]=' + encodeURIComponent(pimg);
        Share.popup(url);
    },
    twitter: function(purl, ptitle, pimg, ptext) {
        url  = 'http://twitter.com/share?';
        url += 'text='      + encodeURIComponent(ptitle);
        url += '&url='      + encodeURIComponent(purl);
        url += '&counturl=' + encodeURIComponent(purl);
        Share.popup(url);
    },
    mailru: function(purl, ptitle, pimg, text) {
        url  = 'http://connect.mail.ru/share?';
        url += 'url='          + encodeURIComponent(purl);
        url += '&title='       + encodeURIComponent(ptitle);
        url += '&description=' + encodeURIComponent(text);
        url += '&imageurl='    + encodeURIComponent(pimg);
        Share.popup(url)
    },
    livejournal: function(purl, ptitle, pimg, ptext, ptaglist)
    {
        url  = 'http://www.livejournal.com/update.bml?';
        url += 'subject='      + encodeURIComponent(ptitle);
        url += '&event='      + encodeURIComponent(purl);
        url += '&prop_taglist=' + encodeURIComponent(ptaglist);
        Share.popup(url);
    },
    linkedin: function(purl, ptitle, pimg, ptext)
    {
        url  = 'https://www.linkedin.com/shareArticle?';
        url += 'url='          + encodeURIComponent(purl);
        url += '&title='       + encodeURIComponent(ptitle);
        url += '&summary='     + encodeURIComponent(ptext);
        Share.popup(url);
    },
    popup: function(url) {
        var width  = 826,
            height = 436,
            left   = (window.screen.availWidth-width)/2,
            top    = (window.screen.availHeight-height)/2;
        window.open(url,'','toolbar=0,status=0,location=0,width=826,height=436,left='+left+',top='+top);
    }
};