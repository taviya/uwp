import logo from "./logo.svg";
import "./App.css";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Header from './component/common/Header';
import Home from "./component/Home";
import Login from "./component/Login";
import Register from "./component/Register";
import Question from "./component/Question";

function App() {
    return (
        <Router>
            <div>
                <Header />
                    <Routes>
                        <Route path="/">
                            <Route
                                path="/"
                                element={<Home />}
                            />

                            <Route
                                path="/question"
                                element={<Question />}
                            />

                            <Route
                                path="/login"
                                element={<Login />}
                            />

                            <Route
                                path="/register"
                                element={<Register />}
                            />
                        </Route>
                    </Routes>
            </div>
        </Router>
    );
}

export default App;
