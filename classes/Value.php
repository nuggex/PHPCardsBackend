<?php

enum Value{
    case Ace;
    case Two;
    case Three;
    case Four;
    case Five;
    case Six;
    case Seven;
    case Eight;
    case Nine;
    case Ten;
    case Jack;
    case Queen;
    case King;

    public function value():int{
        return match($this){
            Value::Ace => 1,
            Value::Two => 2,
            Value::Three => 3,
            Value::Four => 4,
            Value::Five => 5,
            Value::Six => 6,
            Value::Seven => 7,
            Value::Eight => 8,
            Value::Nine => 9,
            Value::Ten => 10,
            Value::Jack => 11,
            Value::Queen => 12,
            Value::King => 13
        };
    }

}