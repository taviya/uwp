import React, { Component } from 'react'
import Loading from './loading.gif'

export default class Spinner extends Component {
  render() {
    return (
      <div className='text-center mt-5 mb-5'>
        <img src={Loading} alt="loading" />
      </div>
    )
  }
}
