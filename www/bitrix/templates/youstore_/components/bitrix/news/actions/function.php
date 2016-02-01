<?
  function sklonen($n,$s1,$s2,$s3, $b = false){
        $m = $n % 10; $j = $n % 100;
        if($b) $n = '<b>'.$n.'</b>';
        if($m==0 || $m>=5 || ($j>=10 && $j<=20)) return $n.' '.$s3;
        if($m>=2 && $m<=4) return  $n.' '.$s2;
        return $n.' '.$s1;
    }
?>