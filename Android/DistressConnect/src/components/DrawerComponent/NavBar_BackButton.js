import React from 'react';
import {TouchableOpacity, Image} from 'react-native';
import {Actions} from 'react-native-router-flux';

const NavBar_BackButton = ({data}) => {
    return (<TouchableOpacity style={{height: 40, width: 40, justifyContent: "center", alignItems: "center", padding:10}}
                              onPress={() => Actions.pop()}>
        <Image style={{height: 15, width: 25}} source={require('../../imgs/back.png')}/>
    </TouchableOpacity>)
}
export default NavBar_BackButton;