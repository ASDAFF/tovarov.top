;(function(window) {
    if (window.JCReviewVoteStars)
        return;

    JCReviewVoteStars = function (params)
    {
        this.progressId = params.progressId;
        this.ratingId = params.ratingId;
        this.starsId = params.starsId;
        this.voteId = params.voteId;
        this.starsObj = null;
        this.votedValue = null;
        this.preVotedValue = null;
        this.inputId = params.inputId;

        console.log('review vote init');
    };

    JCReviewVoteStars.prototype.setValue = function(value)
    {
        value = parseInt(value);
        if (isNaN(value))
            value = 0;
        else if(value > 100)
            value = 100;
        else if(value < 0)
            value = 0;

        var progressObj = BX(this.progressId);

        if(!!progressObj)
        {
            progressObj.style.width = parseInt(value)+"%";
            this.votedValue = value;
        }
    };

    JCReviewVoteStars.prototype.setVotes = function(value)
    {
        var ratingObj = BX(this.ratingId);

        if(!!ratingObj)
            ratingObj.innerHTML = "( "+value+" )";
    };

    JCReviewVoteStars.prototype.getStarsObj = function()
    {
        if(!this.starsObj)
            this.starsObj = BX(this.starsId).parentNode;

        return this.starsObj;
    };

    //todo: IE 8 has no pageX, pageY.
    JCReviewVoteStars.prototype.onMouseMove = function(event)
    {
        console.log('review vote mouse move');

        var starsPos = BX.pos(this.getStarsObj());

        var voteValue = (event.pageX - starsPos.left)/starsPos.width*5;

        for (var i = 1; i <= 5; i++)
        {
            if(voteValue < i)
            {
                voteValue = i;
                break;
            }
        }

        this.setValue(voteValue*20);
    };

    JCReviewVoteStars.prototype.onMouseOver = function(event)
    {
        console.log('review vote mouse over');
        BX.bind(this.getStarsObj(), 'click', BX.proxy(this.onVote, this));
        //this.preVotedValue = this.votedValue;
    };

    JCReviewVoteStars.prototype.onMouseOut = function(event)
    {
        console.log('review vote mouse out');
        BX.unbind(this.getStarsObj(), 'click', BX.proxy(this.onVote, this));
        //this.votedValue = this.preVotedValue;
        //this.setValue(this.votedValue);
    };

    JCReviewVoteStars.prototype.onVote = function(event)
    {
        console.log('review vote voting');
        //this.unBindEvents();

        /*this.ajaxParams.rating = parseInt(this.votedValue/20)-1;
         this.ajaxParams.vote = "Y";
         this.ajaxParams.vote_id = this.voteId;*/
        BX(this.inputId).value = parseInt(this.votedValue/20);
        this.setValue(this.votedValue);
        /*BX.ajax({
         timeout:   30,
         method:   'POST',
         dataType: 'json',
         url:       this.ajaxUrl,
         data:      this.ajaxParams,
         onsuccess: BX.delegate(this.SetResult, this)
         });*/
    };

    JCReviewVoteStars.prototype.SetResult = function(result)
    {
        if (!!result && !result.ERROR)
        {
            this.setValue((result.value+1)*20);
            this.setVotes(result.votes);
        }
    };

    JCReviewVoteStars.prototype.bindEvents = function()
    {
        console.log('review vote bind events');
        var starsObj = this.getStarsObj();
        BX.bind(starsObj.parentNode, 'mousemove', BX.proxy(this.onMouseMove, this));
        BX.bind(starsObj.parentNode, 'mouseover', BX.proxy(this.onMouseOver, this));
        BX.bind(starsObj.parentNode, 'mouseout', BX.proxy(this.onMouseOut, this));
    };

    JCReviewVoteStars.prototype.unBindEvents = function()
    {
        var starsObj = this.getStarsObj();
        BX.unbind(starsObj.parentNode, 'mousemove', BX.proxy(this.onMouseMove, this));
        BX.unbind(starsObj.parentNode, 'mouseover', BX.proxy(this.onMouseOver, this));
        BX.unbind(starsObj.parentNode, 'mouseout', BX.proxy(this.onMouseOut, this));
        BX.unbind(this.getStarsObj(), 'click', BX.proxy(this.onVote, this));
    };
})(window);