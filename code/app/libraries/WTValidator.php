<?php

class WTValidator extends Illuminate\Validation\Validator{
    public function validateWordcount($attribute, $value, $parameters){
        $this->requireParameterCount(2, $parameters, 'wordcount');
        $words = count(preg_split('/\s+/', $value));
        
        return $words >= $parameters[0] && $words <= $parameters[1];
    }
    
    protected function replaceWordcount($message, $attribute, $rule, $parameters){
		return str_replace([':min', ':max'], $parameters, $message);
	}
}