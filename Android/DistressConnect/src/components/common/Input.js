import React from 'react';
import {View, Text, TextInput} from 'react-native';

const Input = ( {label, value, onChangeText, placeholder, secureTextEntry}) => {
    const {inputStyle,lableStyle,containerStyle} = styles;
    return (
        <View style = {containerStyle}>
            <Text style = {lableStyle}> {label}</Text>
            <TextInput
                autoCorrect = {false}
                value = {value}
                secureTextEntry = {secureTextEntry}
                placeholder = {placeholder}
                onChangeText = {onChangeText}
                style = {inputStyle}
            />
        </View>
    );
};

const styles = {
  inputStyle:{
      color: "#000",
      paddingRight: 5,
      paddingLeft: 5,
      fontSize: 18,
      lineHeight: 23,
      flex: 2
  },
  lableStyle: {
      fontSize: 18,
      color:'#000',
      paddingLeft: 20,
      flex: 1
  },
  containerStyle:{
      heigit:40,
      flex:1,
      flexDirection:'row',
      alignItems:'center'
  }
};

export { Input };