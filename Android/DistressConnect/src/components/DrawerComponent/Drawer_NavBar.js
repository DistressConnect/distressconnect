import { Image, Platform, StyleSheet, Text, TouchableOpacity, View } from 'react-native'
import React from 'react'
import { Actions } from 'react-native-router-flux'
import {NAVIGATION_BAR_COLOR,STATUS_BAR_COLOR,FONT_FAMILY,FONT_FAMILY_BOLD,MODAL_BG_COLOR} from '../../config/ConfigStyle';
const styles = StyleSheet.create({
  container: {
    height: (Platform.OS === 'ios') ? 64 : 64,
    flexDirection: 'row',

  },
  navBarItem: {
    flex: 1,
    justifyContent: 'center',
  }
});

export default class Drawer_SearchNavBar extends React.Component {

  // constructor(props) {
  //   super(props)
  // }
    handleSearch = () => {
        switch (this.props.search) {
            case "UserSearchVendorComponent":
                Actions.UserSearchVendorComponent();

                break;
           /* case "ETA":
                Actions.Eta();
                break;
            case "ETD":
                Actions.Etd();
                break;
            case "Plan":
                Actions.JourneyPlanner();
                break;*/
        }
    };
  _renderLeft() {
    // if (Actions.currentScene === 'customNavBar1') {
      return (
        <TouchableOpacity
          onPress={() => Actions.drawerOpen()}
          style={[styles.navBarItem, {flex:0.2, paddingLeft: 10}]}>
          <Image
            style={{width: 20, height: 60}}
            resizeMode="contain"
            source={require("../../imgs/menu.png")}/>
          {/*//  source={{uri: 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Hamburger_icon.svg/1200px-Hamburger_icon.svg.png'}}></Image>*/}
        </TouchableOpacity>
      )
    // } 
  }

  _renderMiddle() {
    return (
      <View style={[styles.navBarItem,{flex:0.6,alignItems:"center",justifyContent:"center"}]}>
        <Text style={{fontSize:17,color:MODAL_BG_COLOR, fontFamily:FONT_FAMILY_BOLD}}>{ this.props.title }</Text>
      </View>
    )
  }

  _renderRight() {
    return (
      <View style={[styles.navBarItem, { flex:0.2,flexDirection: 'row', justifyContent: 'flex-end'}]}>
        {/* <TouchableOpacity
          onPress={() => console.log('Share')}
          style={{ paddingRight: 10}}>
          <Image
            style={{width: 30, height: 50}}
            resizeMode="contain"
            source={{uri: 'https://cdn3.iconfinder.com/data/icons/glypho-free/64/share-512.png'}}></Image>
        </TouchableOpacity> */}
        
      </View>
    )
  }

  render() {
    let dinamicStyle = {}
    if (Actions.currentScene === 'customNavBar1') {
      dinamicStyle = { backgroundColor: STATUS_BAR_COLOR,elevation:0}
    } else {
      dinamicStyle = { backgroundColor: STATUS_BAR_COLOR,elevation:0}
    }

    return (
        <View style={[styles.container, dinamicStyle]}>
          { this._renderLeft() }
          { this._renderMiddle() }
          { this._renderRight() }
        </View>
    )
  }
}
