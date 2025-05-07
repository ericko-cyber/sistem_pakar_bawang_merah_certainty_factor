<style>
    .subcontainer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        width: 900px;
        height: 680px;
        max-height: fit-content;
        background-color: #e2e3e3;
        padding: 10px;
        box-shadow: rgba(128, 128, 128, 0.6) 0px 7px 19px 0px;
    }

    .top-subcontainer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        width: 80%;
        height: 150px;
    }

    .bottom-subcontainer {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        width: 100%;
        height: calc((700px - 150px) - 40px);
    }

    .left {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50%;
        height: fit-content;
    }

    .left img {
        height: calc((700px - 150px) - 120px);
        width: 370px;
        border: 5px solid transparent;
        outline: 5px solid #E98462;
        object-fit: cover;
        object-position: 60% 0%;
        border-radius: 10px;
    }

    .right {
        display: flex;
        flex-direction: column;
        justify-content: left;
        align-items: left;
        width: 50%;
        height: fit-content;
    }

    .right table {
        display: flex;
        flex-direction: column;
        justify-content: left;
        align-items: left;
        width: 100%;
        border-collapse: collapse;
    }

    .right table th {
        padding: 5px;
        border: none;
        text-align: left;
    }

    .right table td {
        padding: 5px;
        border: none;
    }

    .right button {
        width: 130px;
        margin-top: 10px;
    }

    .right button {
        background-color: #E98462;
        border: 2px solid #000;
        color: #fff;
        padding: 12px 20px;
        border-radius: 5px;
    }

    .right button:hover {
        cursor: pointer;
        background-color: #d1dae0;
        transition: .5s;
        color: #000;
        border: 2px solid #E98462;
    }

    .right h2 {
        margin: 0px;
    }

    .bottom-subcontainer .right span {
        color: #cb2d3e;
        font-size: 35px;
    }

    @media only screen and (max-width: 1024px) {
        .container {
            height: fit-content;
        }

        .subcontainer {
            margin: 10px 0px 0px;
            width: 85%;
            height: fit-content;
        }

        .top-subcontainer {
            width: 100%;
            padding: 20px;
            height: fit-content;
        }

        .bottom-subcontainer {
            display: flex;
            flex-direction: column;
            padding: 0px;
            height: fit-content;
        }

        .right {
            width: 100%;
            height: fit-content;
            padding: 40px;
        }
    }

    @media only screen and (max-width: 630px) {
        .container {
            height: fit-content;
        }

        .subcontainer {
            margin: 20px 0px;
            width: 95%;
            height: fit-content;
        }

        .top-subcontainer {
            width: 100%;
            height: fit-content;
        }

        .bottom-subcontainer {
            display: flex;
            flex-direction: column;
            height: fit-content;
        }

        .left img {
            height: 300px;
            width: 300px;
        }

        .right {
            width: 100%;
            padding: 20px;
        }
    }

    .credit a {
        text-decoration: none;
        color: #000;
        font-weight: 800;
    }

    .credit {
        color: #000;
        text-align: center;
        margin-top: 10px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .credit span {
        color: tomato;
        font-size: 20px;
    }

    .our-tentang .section-heading h2 {
        text-align: center;
        margin: 0px 90px 0px 90px;
        margin-bottom: 80px;
        margin-top: 100px;
        position: relative;
        z-index: 1;
    }
    p{
        font-size: 15px;
        font-weight: 600;
    }
</style>

<div id="tentang" class="our-tentang section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-heading wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
                    <h2><span>Tentang</span> <em>Pakar</em></h2>
                </div>
            </div>
        </div>
        <div class="bottom-subcontainer">
            <div class="left">
                <img src="assets/images/foto_pakar.jpg" alt="Gallyndra Fatkhu Dinata">
            </div>
            <div class="right">
                <h2 class="mb-2"><span>Gallyndra Fatkhu Dinata, S.P., M.P.</span></h2>
                <p>
                    Gallyndra Fatkhu Dinata, S.P., M.P. merupakan dosen di Jurusan Produksi Pertanian, Politeknik Negeri Jember. 
                    Beliau memiliki keahlian dalam bidang budidaya pertanian dan pengelolaan tanaman hortikultura, serta aktif dalam berbagai kegiatan penelitian pada tanaman maupun hama. 
                    Sebagai pakar, beliau telah banyak membantu mahasiswa dalam mengembangkan penelitian yang aplikatif di bidang pertanian modern.
                </p>
                <table>
                    <tr>
                        <th>Nama :</th>
                        <td>Gallyndra Fatkhu Dinata, S.P., M.P.</td>
                    </tr>
                    <tr>
                        <th>NIP :</th>
                        <td>199604302022031004</td>
                    </tr>
                    <tr>
                        <th>NIDN :</th>
                        <td>0030049603</td>
                    </tr>
                    <tr>
                        <th>Email :</th>
                        <td>gallyndra.fatkhu@polije.ac.id</td>
                    </tr>
                    <tr>
                        <th>Institusi :</th>
                        <td>Politeknik Negeri Jember</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
