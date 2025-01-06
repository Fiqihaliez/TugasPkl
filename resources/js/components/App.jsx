import React, { useEffect, useState } from "react";
import axios from "axios";

function App() {
    const [data, setData] = useState(null);

    useEffect(() => {
        axios.get("/").then((response) => {
            setData(response.data);
        }).catch((error) => {
            console.error("Error fetching data:", error);
        });
    }, []);

    return (
        <div>
            <h1>Laravel-React Integration</h1>
            {data ? (
                <div>
                    <p>{data.message}</p>
                    <pre>{JSON.stringify(data, null, 2)}</pre>
                </div>
            ) : (
                <p>Loading...</p>
            )}
        </div>
    );
}

export default App;
