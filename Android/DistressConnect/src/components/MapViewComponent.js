/**
 * Distress Connect Site Template
 * @version v1.0.0
 * @link
 * Copyright (c) 2019  Distress Connect
 * @Author Team Distress Connect
 * IBM : CALL FOR CODE 2019 Global Challange
 */

import React, { Component } from "react";
import {
  Platform,
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  Image,
  Alert,
  ActivityIndicator,
  ScrollView
} from "react-native";
import MapView, { Marker, Polyline } from "react-native-maps";
import BlinkView from "react-native-blink-view";
import HTMLView from "react-native-htmlview";

import AutoScrolling from "react-native-auto-scrolling";
import { Actions } from "react-native-router-flux";
import { USER_SEARCH } from "../config/Config";
import { getMessageFromSrvr, getLatLng } from "../actions/LoginActions";
import { connect } from "react-redux";
import WebView from "react-native-webview";
// 9776275946
import {
  saveData,
  getSavedData
} from "../business/common/AsyncStorage/AsyncStorageDB";

let markerPositions = [
  { marker: { latitude: 21.23756, longitude: 84.530325 }, title: "Naktideul" }
  // { marker: { latitude: 21.25189, longitude: 84.75076 }, title: "Levarapal" },
  // { marker: { latitude: 21.134979, longitude: 84.366164 }, title: "Sambalpur" },
  // { marker: { latitude: 21.143072, longitude: 84.637956 }, title: "Odisha" },
  // { marker: { latitude: 21.140329, longitude: 84.91672 }, title: "Luhurakote" },
  // { marker: { latitude: 21.011208, longitude: 84.54107 }, title: "Odisha" },
  // { marker: { latitude: 21.017049, longitude: 84.785086 }, title: "Baliamba" },
  // { marker: { latitude: 20.994344, longitude: 85.06428 }, title: "Solada" }
];
const MyStatusBar = ({ backgroundColor, ...props }) => (
  <View style={[styles.statusBar, { backgroundColor }]}>
    <StatusBar translucent backgroundColor={backgroundColor} {...props} />
  </View>
);

class MapViewComponent extends Component {
  constructor() {
    super();
    this.state = {
      show: false,
      btnName: false
    };
  }
  async componentDidMount() {
    this.props.getLatLng();

    this.interval = setInterval(() => this.props.getMessageFromSrvr(), 3000);
  }
  async cleareUserData() {
    await saveData(USER_SEARCH, []);
    this.setState({ btnName: false });
  }
  async getUserData() {
    let data = await getSavedData(USER_SEARCH);
    if (data.hasOwnProperty("uid")) {
      this.setState({ btnName: true });
      Alert.alert(
        "",
        "Are you sure you want to logout ?",
        [
          {
            text: "Maybe later",
            onPress: () => console.log("cancel"),
            style: "cancel"
          },
          { text: "Yes", onPress: () => this.cleareUserData() }
        ],
        { cancelable: true }
      );
    } else {
      Actions.LoginComponent();
    }
  }
  render() {
    const htmlContent = "This is a sentence <b>with</b> one word in bold";
    const INJECTEDJAVASCRIPT = `const meta = document.createElement('meta'); meta.setAttribute('content', 'width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=0'); meta.setAttribute('name', 'viewport'); document.getElementsByTagName('head')[0].appendChild(meta); `;

    debugger;
    return (
      <View style={styles.container}>
        <View
          style={{
            width: "100%",
            height: 60,
            backgroundColor: "#7b2430",
            elevation: 10,
            justifyContent: "center",
            flexDirection: "row"
          }}
        >
          <Image
            style={{
              width: 100,
              height: 50,
              position: "absolute",
              left: 5,
              top: 5
            }}
            source={require("../imgs/logo_tr.png")}
          />
          <Text
            style={{
              color: "white",
              alignSelf: "center",
              fontWeight: "bold",
              fontSize: 18
            }}
          >
            DISTRESS CONNECT
          </Text>
        </View>
        <MapView
          style={{ position: "absolute", left: 0, top: 0, right: 0, bottom: 0 }}
          initialRegion={{
            latitude: 20.294981,
            longitude: 85.824713,
            latitudeDelta: 0.1,
            longitudeDelta: 0.1
          }}
        >
          {this.props.latlng.map(marker => (
            <Marker
              coordinate={marker.marker}
              // centerOffset={{ x: -18, y: -60 }}
              // anchor={{ x: 0.69, y: 1 }}
              title={marker.fullname}
              //image={this.state.marker1 ? flagBlueImg : flagPinkImg}
            />
          ))}
        </MapView>
        {this.state.show ? (
          <View
            style={{
              width: "67%",
              height: "29%",
              alignSelf: "flex-end",
              backgroundColor: "rgba(169,163,53,0.7)",
              marginTop: 20
            }}
          >
            <View style={{ width: "100%", height: "90%" }}>
              <View
                style={{ width: "100%", height: 1, backgroundColor: "#ccc" }}
              />
              <View
                style={{
                  width: "100%",
                  height: 40,
                  justifyContent: "center",
                  alignItems: "center",
                  backgroundColor: "rgba(123,36,48,0.8)"
                }}
              >
                <Text style={{ color: "#fff" }}>Live Alert</Text>
              </View>
              <View
                style={{ width: "100%", height: 1, backgroundColor: "#ccc" }}
              />
              <View
                style={{
                  width: "100%",
                  height: "100%",
                  alignSelf: "center",
                  marginTop: 10
                }}
              >
                <View
                  style={{
                    width: "90%",
                    height: "40%",
                    alignSelf: "center",
                    alignItems: "center",

                    flexDirection: "row",
                    backgroundColor: "#fff"
                  }}
                  // delay={3000}
                  // endPaddingWidth={100}
                >
                  <Image
                    style={{
                      width: 60,
                      height: 60
                    }}
                    source={require("../imgs/weather.png")}
                  />

                  <WebView
                    style={{
                      flex: 1,
                      alignItems: "center",
                      justifyContent: "center"
                    }}
                    scalesPageToFit={true}
                    injectedJavaScript={INJECTEDJAVASCRIPT}
                    scrollEnabled
                    source={{
                      html: this.props.msgs.hasOwnProperty("wheather_info_msg")
                        ? "<p style=text-align:left;><font size=5.9>" +
                          this.props.msgs.wheather_info_msg +
                          "</font></p>"
                        : "<p style=text-align:left;><font size=5.9>Loading</font></p>"
                    }}
                  />
                </View>
                <View
                  style={{
                    width: "90%",
                    height: "40%",
                    flexDirection: "row",
                    alignSelf: "center",
                    alignItems: "center",
                    backgroundColor: "#fff"
                  }}
                  // delay={3000}
                  // endPaddingWidth={100}
                >
                  <Image
                    style={{
                      width: 60,
                      height: 60
                    }}
                    source={require("../imgs/alert-boxs.png")}
                  />
                  <WebView
                    style={{ flex: 1 }}
                    scalesPageToFit={true}
                    injectedJavaScript={INJECTEDJAVASCRIPT}
                    scrollEnabled
                    source={{
                      html: this.props.msgs.hasOwnProperty("wheather_alert_msg")
                        ? "<p style=text-align:left;><font size=5.9>" +
                          this.props.msgs.wheather_alert_msg +
                          "</font></p>"
                        : "<p style=text-align:left;><font size=5.9>Loading..</font></p>"
                    }}
                  />
                </View>
              </View>
            </View>
          </View>
        ) : null}
        <View
          style={{
            width: "50%",
            height: "10%",
            alignSelf: "flex-end",
            alignItems: "center",
            justifyContent: "center"
          }}
        >
          <BlinkView blinking={false} delay={100}>
            <Image source={require("../imgs/logo.png")} />
          </BlinkView>
        </View>
        <View
          style={{
            width: 50,
            height: 50,
            position: "absolute",
            right: 10,
            bottom: 60,
            backgroundColor: "#fff",
            borderRadius: 50,
            borderWidth: 1,
            borderColor: "#fff",
            elevation: 10
          }}
        >
          {/* {this.props.msgLoading ? (
            <ActivityIndicator size="large" color="#a82b2d" />
          ) : ( */}
          <TouchableOpacity
            style={{
              width: "100%",
              height: "100%",
              justifyContent: "center",
              alignItems: "center"
            }}
            onPress={() => this.setState({ show: !this.state.show })}
          >
            <Text
              style={{
                fontSize: 30,
                fontWeight: "bold",
                paddingBottom: 5,
                color: "#7b2430"
              }}
            >
              {this.state.show ? "-" : "+"}
            </Text>
          </TouchableOpacity>
        </View>
        <View
          style={{
            position: "absolute",
            left: 0,
            right: 0,
            bottom: 0,
            height: 50,
            elevation: 10,
            backgroundColor: "#fff",
            flexDirection: "row",
            justifyContent: "space-between"
          }}
        >
          <TouchableOpacity
            style={{
              width: "66%",
              height: "100%",
              backgroundColor: "#fff",
              alignItems: "center",
              justifyContent: "center",
              elevation: 5
            }}
            onPress={() => console.log("")}
          >
            <Text style={{ color: "#7b2430" }}>Connect LoRa</Text>
          </TouchableOpacity>
          <View style={{ width: 1, height: "100%", backgroundColor: "#ccc" }} />

          {/* <TouchableOpacity
            style={{
              width: "33%",
              height: "100%",
              backgroundColor: "#fff",
              alignItems: "center",
              justifyContent: "center",
              elevation: 5
            }}
            onPress={() => console.log("")}
          >
            <Text>Search</Text>
          </TouchableOpacity>
          <View style={{ width: 1, height: "100%", backgroundColor: "#ccc" }} /> */}
          <TouchableOpacity
            style={{
              width: "33%",
              height: "100%",
              backgroundColor: "#fff ",
              alignItems: "center",
              justifyContent: "center",
              elevation: 5
            }}
            onPress={() => console.log("Login Click")}
          >
            <Text style={{ color: "#7b2430" }}>
              {" "}
              {this.state.btnName ? "Log Out" : "Login"}{" "}
            </Text>
          </TouchableOpacity>
        </View>
      </View>
    );
  }
}
const mapStateToProps = ({ login }) => {
  // email:auth.state.email;
  const { msgLoading, msgs, latlng } = login;
  return { msgLoading, msgs, latlng };
};
export default connect(
  mapStateToProps,
  { getMessageFromSrvr, getLatLng }
)(MapViewComponent);
const styles = StyleSheet.create({
  container: {
    flex: 1,
    // justifyContent: "center",
    // alignItems: "center",
    backgroundColor: "#F5FCFF"
  }
  // map: {
  //   position: "absolute",
  //   top: 0,
  //   left: 0,
  //   button: 0,
  //   right: 0
  // }

  // https://feeble.in/distress_connect/service/get?op=GET_NODE_MESSAGE_DATA
  // http://feeble.in/distress_connect/user/login
  // username:admin@com
  //password:admin@1a
});
