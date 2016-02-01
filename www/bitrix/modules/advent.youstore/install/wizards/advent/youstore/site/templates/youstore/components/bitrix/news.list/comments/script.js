;(function(window) {
    if (window.JCReviewUserVote)
        return;
    JCReviewUserVote = function (params)
    {
        console.log('review user vote init');

        this.ID = params.ID;
        this.VOTE_PLUS_ID = params.VOTE_PLUS;
        this.VOTE_MINUS_ID = params.VOTE_MINUS;
        this.COMMENT_ID = params.COMMENT_ID;
        //TODO: REPLY

        this.VOTE_PLUS_OBJ = BX(this.VOTE_PLUS_ID);
        this.VOTE_MINUS_OBJ = BX(this.VOTE_MINUS_ID);
        this.ajaxUrl = params.AJAX_URL;
    };

    JCReviewUserVote.prototype.onPlusVote = function()
    {
        value = 1;
        this.vote(this.COMMENT_ID, value);
    };

    JCReviewUserVote.prototype.onMinusVote = function()
    {
        value = -1;
        this.vote(this.COMMENT_ID, value);
    };

    JCReviewUserVote.prototype.vote = function(element_id, value){
         var ajaxVoteParams = "element_id="+element_id+"&value="+value;
         BX.ajax({
             timeout:   30,
             method:   'POST',
             dataType: 'json',
             url:       this.ajaxUrl,
             data:      ajaxVoteParams,
             onsuccess: BX.delegate(this.setResult, this)
         });
    }

    JCReviewUserVote.prototype.showError = function(error_code){
        console.log(error_code);
    }

    JCReviewUserVote.prototype.setResult = function(result){
        if(result["result"]){
            this.VOTE_PLUS_OBJ.innerHTML = (parseInt(result["VOTE_PLUS"], 10) || 0);
            this.VOTE_MINUS_OBJ.innerHTML = (parseInt(result["VOTE_MINUS"], 10) || 0);
        }else{
            this.showError(result["ERROR_CODE"]);
        }
    }

    JCReviewUserVote.prototype.bindEvents = function()
    {
        console.log('review user vote bind events');
        BX.bind(this.VOTE_PLUS_OBJ, 'click', BX.proxy(this.onPlusVote, this));
        BX.bind(this.VOTE_MINUS_OBJ, 'click', BX.proxy(this.onMinusVote, this));
    };
})(window);