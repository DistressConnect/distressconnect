import React, { Component } from "react";
import {
  StyleSheet,
  Alert,
  View,
  Text,
  Image,
  TouchableOpacity,
  TouchableWithoutFeedback,
  AsyncStorage
} from "react-native";
import { Actions } from "react-native-router-flux";
import {
  COMMON_GREEN_COLOR,
  STATUS_BAR_COLOR,
  FONT_FAMILY,
  FONT_FAMILY_BOLD,
  MODAL_BG_COLOR
} from "../../config/ConfigStyle";
class DrawerItem extends Component {
  navigate(route) {}

  render() {
    const { name, route, icon } = this.props.route;
    return (
      <View style={styles.container}>
        {/* <TouchableWithoutFeedback onPress={this.handleClick}>
                    <View style={styles.containerStyle}>
                        <Image source={icon} style={{width: 22, height: 22, marginLeft: 5, marginRight: 20}}/>
                        <Text style={styles.textStyle}> {name} </Text>
                    </View>
                </TouchableWithoutFeedback> */}
        <TouchableWithoutFeedback
          onPress={() => this.props.fromClass.func_setSelectedIndex(route)}
        >
          {this.func_getSelectedView(route, name)}
        </TouchableWithoutFeedback>
        <View style={{width:'90%',height:0.5, backgroundColor:"#ccc",alignSelf:'center'}}/>
      </View>
    );
  }

  func_getSelectedView(route, name) {
    if (this.props.selectedIndex == route) {
      return (
        <View
          style={[
            styles.containerStyle,
            { backgroundColor: "rgba(0,0,0,0.5)" }
          ]}
        >
          {this.func_getIcon(route)}
          <Text style={[styles.textStyle, { color: "#fff" }]}>{name}</Text>
        </View>
      );
    } else {
      return (
        <View
          style={[styles.containerStyle, { backgroundColor: "transparent" }]}
        >
          {this.func_getIcon(route)}
          <Text style={[styles.textStyle,{ color: "#fff" }]}>{name}</Text>
        </View>
      );
    }
  }

  func_getIcon(itemName) {
    switch (itemName) {
      case "TrainingTrackingForm":
        return (
          <Image
            source={require("../../imgs/presentation.png")}
            style={{ width: 25, height: 25, marginLeft: 5, marginRight: 20 }}
          />
        );
        break;
      case "LogData":
        return (
          <Image
            source={require("../../imgs/folder.png")}
            style={{ width: 25, height: 25, marginLeft: 5, marginRight: 20 }}
          />
        );
        break;
      case "Logout":
        return (
          <Image
            source={require("../../imgs/logout.png")}
            style={{ width: 25, height: 25, marginLeft: 5, marginRight: 20 }}
          />
        );
        break;

      default:
        break;
    }
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "transparent",
    marginTop: 0,
    justifyContent: "center"
  },
  containerStyle: {
    //  borderBottomWidth: 0.3,
    padding: 10,
    paddingBottom: 10,
    backgroundColor: STATUS_BAR_COLOR,
    justifyContent: "flex-start",
    flexDirection: "row",
    // borderColor: '#ddd',
    position: "relative",
    height: 60,
    alignItems: "center"
  },
  textStyle: {
    color: COMMON_GREEN_COLOR,
    fontSize: 16,
    fontFamily: FONT_FAMILY_BOLD
  }
});
export default DrawerItem;
