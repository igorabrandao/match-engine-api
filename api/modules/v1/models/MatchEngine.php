<?php

namespace api\modules\v1\models;

class MatchEngine
{
        /**
		 * Function responsable for doing the match research
		 */
		public findMatchList()
		{
		    // TODO
		}
		
		/**
		 *  Function responsable to remove some item in the match list
		 * 
		 *  @param matchList_ => list containing all the rejected matches
		 */
		public rejectMatch(matchList_ = null)
		{
		    // TODO
		}
		
		/**
		 *  Function responsable to accept a match
		 * 
		 *  @param itemList => list of matches accepted by
		 *	@param user => the user
		 */
		public acceptMatch($itemList, $user)
		{
			// Will call function from DecisionMaker interface
		}

}
