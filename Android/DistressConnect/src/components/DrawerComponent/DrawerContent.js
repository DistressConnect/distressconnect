import React from "react";
import PropTypes from "prop-types";
import {
  StyleSheet,
  Text,
  View,
  ViewPropTypes,
  FlatList,
  Image,
  Platform,
  ImageBackground,
  TouchableOpacity,
  TouchableWithoutFeedback,
  Alert,
  //NetInfo,
  Button
} from "react-native";
import DrawerItem from "./DrawerItem";
import { Actions } from "react-native-router-flux";
import { connect } from "react-redux";
import {
  STATUS_BAR_COLOR,
  COMMON_GREEN_COLOR,
  FONT_FAMILY,
  FONT_FAMILY_BOLD,
  MODAL_BG_COLOR
} from "../../config/ConfigStyle";
import {
  getUserDetails,
  getGroupVendorDetails,
  updateBase64,
  setBase64ForUser
} from "../../actions";
import { USER_PROFILE_IMAGE_API, USER_SEARCH } from "../../config/Config";
import {
  clearLoginSession,
  getLoginSessionData,
  saveData
} from "../../business/common/AsyncStorage/AsyncStorageDB";
let data = {};
let imagePath = null;
let image64 = null;
import NetInfo from "@react-native-community/netinfo";

const styles = StyleSheet.create({
  container: {
    flex: 2,
    backgroundColor: STATUS_BAR_COLOR
  },
  textFontStyle: {
    color: "#fff",
    fontSize: 17,
    marginTop: 5,
    fontFamily: FONT_FAMILY_BOLD
  },
  text2nd: {
    color: "#fff",
    fontSize: 16,
    marginTop: 2,
    fontFamily: FONT_FAMILY
  }
});

class DrawerContent extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      selectedIndex: null,
      userName: "Login",
      mobile: "",
      datas: [],
      refresh: false
    };
  }

  func_refreshComponent() {
    this.func_getAllUserData();

    this.setState({
      refresh: !this.state.refresh
    });
  }

  async componentWillMount() {
    //data = await getLoginSessionData();
    // this.func_getAllUserData();
    this.renderData();
    //this.CheckConnectivity();
    //
    // debugger;
    // if(data.hasOwnProperty("user_id")){

    // }else{
    //     Actions.OtpLoginComponent();
    // }
  }
  async func_getAllUserData() {
    if (data.hasOwnProperty("vendor_type")) {
      if (data.vendor_type === "I" || data.vendor_type === "C") {
        this.setState({ selectedIndex: "" });
        await this.props.getGroupVendorDetails();
      }
    } else {
      this.setState({ selectedIndex: "UserSearchVendorComponent" });
      await this.props.getUserDetails();
    }
  }

  static propTypes = {
    name: PropTypes.string,
    sceneStyle: ViewPropTypes.style,
    title: PropTypes.string
  };

  renderData() {
    return (this.state.datas = [
      {
        name: "Training Tracking",
        route: "TrainingTrackingForm",
        icon: require("../../imgs/back.png"),
        bg: "#C5F442"
      },
      {
        name: "Log Data",
        route: "LogData",
        icon: require("../../imgs/back.png"),
        bg: "#C5F442"
      },
      {
        name: "Logout",
        route: "Logout",
        icon: require("../../imgs/back.png"),
        bg: "#C5F442"
      }
    ]);
  }

  static contextTypes = {
    drawer: PropTypes.object
  };

  // CheckConnectivity = () => {
  //   // For Android devices
  //   NetInfo.fetch().then(state => {
  //       console.log("Connection type", state.type);
  //       console.log("Is connected?", state.isConnected);
  //       alert(state.type)
  //       alert(state.isConnected)
  //     });
  // };

  handleFirstConnectivityChange = isConnected => {
    NetInfo.isConnected.removeEventListener(
      "connectionChange",
      this.handleFirstConnectivityChange
    );

    if (isConnected === false) {
      Alert.alert("You are offline!");
    } else {
      Alert.alert("You are online!");
    }
  };

  func_setSelectedIndex(indexName) {
    Actions.drawerClose();
    switch (indexName) {
      case "TrainingTrackingForm":
        Actions.TrainingTrackingForm();
        break;
      case "LogData":
        Actions.LogData();
        break;
      case "Logout":
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
        break;

      default:
        break;
    }

    this.setState({
      selectedIndex: indexName
    });
  }

  async cleareUserData() {
    await saveData(USER_SEARCH, []);

    //  await clearLoginSession();
    Actions.LoginComponent();
  }
  renderRoutes() {
    return (
      <FlatList
        data={this.state.datas}
        keyExtractor={(item, index) => index.toString()}
        renderItem={({ item }) => (
          <DrawerItem
            key={item.route}
            fromClass={this}
            selectedIndex={this.state.selectedIndex}
            route={item}
          />
        )} // key={item.routeno} route={item} navigate={this.props.navigation}
        extraData={this.state}
      />
    );
  }
  checkConnection() {
    NetInfo.isConnected.fetch().then(isConnected => {
      if (isConnected) {
        console.log("Internet is connected");
      }
    });
  }
  //
  render() {
    // this.getUserRecord();
    console.log("Action data " + this.props.base64_dataimg);
    return (
      <View style={{ flex: 1, backgroundColor: COMMON_GREEN_COLOR }}>
        {/* <View style={{flex: 1, backgroundColor: "red", justifyContent: 'center', alignItems: 'center',}}><Text>image</Text></View>*/}

        <View style={styles.container}>
          {/* <ImageBackground
            resizeMode="cover"
            style={{ flex: 1 }}
            source={require("../../imgs/drawer-header-background.png")}
          > */}
          <View style={{ flex: 1, backgroundColor: "#af2e2f" }}>
            {this.renderRoutes()}
          </View>
          {/* </ImageBackground> */}
        </View>
        <View
          style={[
            {
              width: "100%",
              height: 40,
              justifyContent: "center",
              alignItems: "center"
            },
            this.props.is_connection
              ? { backgroundColor: "#0f0" }
              : { backgroundColor: "#f00" }
          ]}
        >
          <Text>
            {this.props.is_connection
              ? "Internet Connected"
              : "Not Connected to Internet"}
          </Text>
        </View>
      </View>
    );
  }
}
const mapStateToProps = ({ formtt }) => {
  // email:auth.state.email;
  const { is_connection } = formtt;
  return { is_connection };
};
export default connect(
  mapStateToProps,
  {}
)(DrawerContent);
