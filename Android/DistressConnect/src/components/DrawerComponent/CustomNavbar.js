import { Image, Platform, StyleSheet, Text, TouchableOpacity, View } from 'react-native'
import React from 'react'
import { Actions } from 'react-native-router-flux'
import {NAVIGATION_BAR_COLOR,STATUS_BAR_COLOR,FONT_FAMILY,FONT_FAMILY_BOLD,MODAL_BG_COLOR} from '../../config/ConfigStyle';

export default class CustomNavbar extends React.Component {

    render(){
        return(
            <View style={[styles.container]}>
                { this._renderLeft() }
                { this._renderMiddle() }
                { this._renderRight() }
            </View>
        )
    }
    _renderLeft(){
        return(
            <TouchableOpacity onPress={() => Actions.pop()}
            style={[styles.navBarItem, { flex:0.2,paddingLeft: 10}]}>
                <Image resizeMode="contain" source={require('../../imgs/back.png')} style={{width: 20, height: 60}}/>
            </TouchableOpacity>
        )
    }

    _renderMiddle(){
        return(
            <View style={[styles.navBarItem,{flex:0.6, alignItems:"center"}]}>
                <Text style={{fontSize:18,color:MODAL_BG_COLOR, fontFamily:FONT_FAMILY_BOLD}}>{ this.props.title }</Text>
            </View>
        )
    }

    _renderRight() {
        return (
          <View style={[styles.navBarItem, {flex:0.2,justifyContent: 'flex-end'}]}>
          </View>
        )
      }
    
}

const styles = StyleSheet.create({
    container: {
      height: (Platform.OS === 'ios') ? 64 : 64,
      flexDirection: 'row',
      backgroundColor:STATUS_BAR_COLOR,  
    },
    navBarItem: {
      flex: 1,
      justifyContent: 'center',
    }
  });