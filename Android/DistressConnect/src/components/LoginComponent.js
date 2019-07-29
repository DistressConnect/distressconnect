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
  Alert,
  Button,
  TextInput,
  View,
  StyleSheet,
  Text,
  TouchableOpacity,
  ActivityIndicator,
  BackHandler
} from "react-native";
import { connect } from "react-redux";
import { Actions } from "react-native-router-flux";
import { onClickLogin } from "../actions/LoginActions";
import Snackbar from "react-native-snackbar";

class LoginComponent extends Component {
  constructor(props) {
    super(props);

    // this.state = {
    //   uid: "fo@forants.com",
    //   password: "tarina@1a"
    // };
    this.state = {
      uid: "",
      password: ""
    };
    this.handleBackButtonClick = this.handleBackButtonClick.bind(this);
  }
  func_ShowAlert(msg) {
    Snackbar.show({
      title: msg,
      color: "white",
      duration: Snackbar.LENGTH_SHORT
    });
  }
  componentWillMount() {
    BackHandler.addEventListener(
      "hardwareBackPress",
      this.handleBackButtonClick
    );
  }
  componentWillUnmount() {
    BackHandler.removeEventListener(
      "hardwareBackPress",
      this.handleBackButtonClick
    );
  }

  handleBackButtonClick() {
    //alert(Actions.currentScene)
    //this.func_ShowAlert ("Hello");
    // Snackbar.show({
    //   title: 'Press Exit to Close the app',
    //   color:'white',
    //   duration: Snackbar.LENGTH_SHORT,
    //   action: {
    //     title: 'EXIT',
    //     color: 'red',
    //     onPress: () => { BackHandler.exitApp() },
    //   },
    // });
    //BackHandler.exitApp();
    Actions.pop();
    return true;
  }
  onLogin() {
    //Actions.TrainingTrackingForm()
    const { uid, password } = this.state;
    if (uid == "") {
      this.func_ShowAlert("Enter User Name");
    } else if (password == "") {
      this.func_ShowAlert("Enter Password ");
    } else {
      // this.props.onClickLogin(uid, password);
      //Actions.TrainingTrackingForm();
    }
    //  Alert.alert("Credentials", `${username} + ${password}`);
  }

  render() {
    return (
      <View style={styles.container}>
        <View style={styles.dialogContainer}>
          <Text
            style={{
              color: "#000",
              fontWeight: "bold",
              fontSize: 20,
              marginTop: 20
            }}
          >
            Log In
          </Text>

          <View
            style={{
              marginTop: 30,
              width: "100%",
              alignItem: "center",
              justifyContent: "center"
            }}
          >
            <Text style={styles.loginFieldtitle}>User Name</Text>
            <TextInput
              value={this.state.uid}
              onChangeText={uid => this.setState({ uid })}
              placeholder={"Username"}
              style={styles.input}
            />
            <Text style={styles.loginFieldtitle}>Password</Text>
            <TextInput
              value={this.state.password}
              onChangeText={password => this.setState({ password })}
              placeholder={"Password"}
              secureTextEntry={true}
              style={styles.input}
            />

            {this.props.loginLoading ? (
              <ActivityIndicator size="large" color="#a82b2d" />
            ) : (
              <TouchableOpacity
                style={styles.loginButton}
                onPress={() => this.onLogin()} //Actions.TrainingTrackingForm()
              >
                <Text
                  style={{
                    color: "#fff",
                    textAlign: "center",
                    fontSize: 15,
                    fontWeight: "bold"
                  }}
                >
                  Log In
                </Text>
              </TouchableOpacity>
            )}
            <TouchableOpacity style={{ marginTop: 5 }}>
              <Text style={{ color: "#a82b2d" }}>Forgot Password ?</Text>
            </TouchableOpacity>
          </View>
        </View>
      </View>
    );
  }
}
const mapStateToProps = ({ login }) => {
  // email:auth.state.email;
  const { loginLoading } = login;
  return { loginLoading };
};
export default connect(
  mapStateToProps,
  { onClickLogin }
)(LoginComponent);

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    backgroundColor: "#af2e2f"
  },
  input: {
    width: "100%",
    height: 44,
    padding: 10,
    borderWidth: 0.5,
    borderColor: "#ccc",
    borderRadius: 5,
    marginBottom: 10,
    marginTop: 6
  },
  dialogContainer: {
    backgroundColor: "#fff",
    width: "95%",
    height: 350,
    elevation: 10,
    paddingLeft: 20,
    paddingRight: 20,
    paddingTop: 10,
    paddingBottom: 10
  },
  loginFieldtitle: { color: "#686868", fontWeight: "bold", fontSize: 13 },
  loginButton: {
    backgroundColor: "#ac4051",
    width: "100%",
    height: 40,
    marginTop: 5,
    borderWidth: 0.5,
    borderColor: "#ac4051",
    borderRadius: 5,
    alignItems: "center",
    justifyContent: "center"
  }
});
