/**
 * Distress Connect Site Template
 * @version v1.0.0
 * @link
 * Copyright (c) 2019  Distress Connect
 * @Author Team Distress Connect
 * IBM : CALL FOR CODE 2019 Global Challange
 */

 
import React from "react";
import {
  Scene,
  Router,
  Actions,
  Overlay,
  Drawer
} from "react-native-router-flux";
import { connect } from "react-redux";
import { connectionCheck } from "./actions/TTFormAction";
import LoginComponent from "./components//LoginComponent";

import CustomNavbar from "./components/DrawerComponent/CustomNavbar";
import DrawerContent from "./components/DrawerComponent/DrawerContent";
import Drawer_NavBar from "./components/DrawerComponent/Drawer_NavBar";
import SplashScreen from "./SplashScreen";
import NetInfo from "@react-native-community/netinfo";
import { getSavedData } from "./business/common/AsyncStorage/AsyncStorageDB";
import MapViewComponent from "./components/MapViewComponent";
let savedData = {};
class RouterComponent extends React.Component {
  async componentWillMount() {
    savedData = await getSavedData(USER_SEARCH);
  }
  componentDidMount() {
    this.interval = setInterval(() => this.CheckConnectivity(), 1000);
  }
  CheckConnectivity = () => {
    // For Android devices
    NetInfo.fetch().then(state => {
      //alert(state.isConnected)
      // let isConnected = state.type;
      let isConnected = state.isConnected;

      this.props.connectionCheck(isConnected);
    });
  };
  render() {
    return (
      //initial is to show the initial screen on scene

      //Grouping this because of not showing the back button
      //sceneStyle={{paddingTop: 65,}}
      <Router
        navigationBarStyle={{ backgroundColor: "#669966", elevation: 10 }}
        titleStyle={{
          fontFamily: "Pacifico-Regular",
          fontSize: 22,
          color: "#fff"
        }}
        navBarButtonColor={{ color: "#fff" }}
      >
        <Overlay key="overlay">
          <Scene
            key="main1"
            //    renderLeftButton={NavBar_BackButton}
            hideNavBar={false}
            navBar={CustomNavbar}
            //backButtonImage={{tintColor:'#ffffff'}}
          >
            {/*
                    <Scene key = "Page2" component = {Page2} title="Login"   initial/>
*/}
            <Scene
              key="MapViewComponent"
              component={MapViewComponent}
              title="Distress Connection"
              hideNavBar
              initial
            />

            <Scene
              key="LoginComponent"
              component={LoginComponent}
              title="Login"
              hideNavBar
            />
            <Scene
              key="Splash"
              component={SplashScreen}
              title="Splash"
              hideNavBar
            />

            <Drawer
              hideNavBar
              key="drawer"
              contentComponent={DrawerContent}
              // drawerImage={require('./imgs/menu.png')}
              navBar={Drawer_NavBar}
              drawerWidth={300}
            >
              <Scene
                key="drawer"
                // backButtonImage={require('./icons/back.png')}
                hideNavBar={false}
                rightTitle="Add"
                //backButtonImage={{tintColor:'#ffffff'}}
              >
                <Scene
                  key="Splash"
                  component={SplashScreen}
                  title="Splash"
                  hideNavBar
                />
              </Scene>
            </Drawer>
          </Scene>
        </Overlay>
      </Router>
    );
  }
}

export default connect(
  null,
  { connectionCheck }
)(RouterComponent);
