<?php 	
// koneksi database

// mysqli_connect('namahost', 'usernamesql', 'password', 'namaDATABASE');
$conn = mysqli_connect("localhost", "root", "", "CRUD_Auth");

// ambil data dari tabel / query
// $result = mysqli_query($conn, "SELECT * FROM datasiswa");
// if( !$result ) {
// 	echo "mysqli error";
// }

// ambil data dari $result (fetch)
// 1. mysqli_fetch_row()
// 2. mysqli_fetch_assoc()
// 3. mysqli_fetch_array()
// 4. mysqli_fetch_object()

// menampilkan data
// mysqli_fetch hanya mengembalikan 1 data jadi harus menggunakan looping

// menampilkan semua data dari table
// while ($siswa = mysqli_fetch_assoc($result)) {
// var_dump($siswa);
// }

// Functions

// fungsi utk query
function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}



// v11
// function tambah2($data) {
// 	global $conn;

// 	// ambil data dari input 
// 	$username = htmlspecialchars($data['username']);
// 	$password = password_hash($data['password'], PASSWORD_DEFAULT);
// 	$email = htmlspecialchars($data['email']);
// 	$phone = htmlspecialchars($data['phone']);
	
// 	// upload foto
// 	$pfp = upload();
// 	if (!$pfp) {
// 		return false;
// 	}


// 	// query insert data
// 	$query = "INSERT INTO user VALUES
// 				('',
// 				 '$username',
// 				  '$password',
// 				   '$email',
// 				    '$telp',
// 				     '$pfp') 
// 			";
// 			mysqli_query($conn, $query);

// 		return mysqli_affected_rows($conn);

// }


//  v11
function upload2() {

	$namaFile = $_FILES['foto']['name'];
	$ukuranFile = $_FILES['foto']['size'];
	$error = $_FILES['foto']['error'];
	$tmpName = $_FILES['foto']['tmp_name'];
	
	// cek foto
	if ($error === 4) {
		echo "<script>alert('Silahkan Upload Foto')</script>";

		return false;
		
	}
	
	// cek ekstensi file
	$extFotoValid = ['jpeg', 'jpg', 'png'];
	$extFoto = explode('.', $namaFile);
	$extFoto = strtolower(end($extFoto));
	if ( !in_array($extFoto, $extFotoValid) ) {
		echo "<script>alert('Ekstensi tidak sah!')</script>";
		
		return false;
	}
	
	// cek ukuran
	$ukuranValid = 5000000;
	if ( $ukuranFile > $ukuranValid ) {
		echo "<script>
		alert('Ukuran Tidak diperbolehkan \n<1MB')
		</script>";
		
		return false;
	}
	
	// upload img
	// generate nama baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $extFoto;
	
	
	move_uploaded_file($tmpName, '../img/' . $namaFileBaru);
	
	return $namaFileBaru;

}


// hapus row
function hapus($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM user WHERE user_id = $id");
	
	return mysqli_affected_rows($conn);
}





// // ubah row
// function ubah($data) {
	// 	global $conn;
	
	// 	// ambil data dari input
	// 	$no = $data['no'];
	// 	$nama = htmlspecialchars($data['nama']);
	// 	$kelas = htmlspecialchars($data['kelas']);
	// 	$nisn = htmlspecialchars($data['nisn']);
	// 	$jurusan = htmlspecialchars($data['jurusan']);
	// 	$email = htmlspecialchars($data['email']);
	// 	$gambarLama = htmlspecialchars($data['gambarLama']);
	
	
	// 	// cek gambar baru
	// 	if ($_FILES['foto']['error'] === 4) {
		// 		$foto = $gambarLama;
		// 	} else {
			// 		$foto = upload();
// 	}




// 	// query insert data
// 	$query = "UPDATE datasiswa SET 
// 				nama = '$nama', 
// 				kelas = '$kelas', 
// 				nisn = '$nisn', 
// 				jurusan = '$jurusan', 
// 				email = '$email', 
// 				foto = '$foto'   
// 			WHERE no = $no
// 				";


// 			mysqli_query($conn, $query);

// 		return mysqli_affected_rows($conn);
// }

// v11
function ubah2($data) {
	global $conn;
	
	// ambil data dari input
	$user_id = htmlspecialchars($data['user_id']);
	$user_username = htmlspecialchars($data['user_username']);
	$user_password = password_hash($data['user_password'], PASSWORD_DEFAULT);
	$user_email = htmlspecialchars($data['user_email']);
	$user_telp = htmlspecialchars($data['user_telp']);
	$user_pfp_old = htmlspecialchars($data['user_pfp_old']);
	
	
	// cek gambar baru
	if ($_FILES['user_pfp']['error'] === 4) {
		$user_pfp = $user_pfp_old;
	} else {
		$user_pfp = upload();
	}
	
	
	
	
	// query insert data
	$query = "UPDATE user SET 
				user_username = '$user_username', 
				user_password = '$user_password', 
				user_email = '$user_email',
				user_telp = '$user_telp', 
				user_pfp = '$user_pfp'
			WHERE user_id = $user_id
				";


mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}

// function cari v10

function cari($keyword, $awalData, $jumlahBaris) {
	$query = "SELECT * FROM datasiswa WHERE
				nama LIKE '%$keyword%'OR 
				kelas LIKE '%$keyword%'OR 
				nisn LIKE '%$keyword%'OR 
				jurusan LIKE '%$keyword%'OR 
				email LIKE '%$keyword%'
				LIMIT $awalData, $jumlahBaris";

return query($query);
}

// function cari v10.2

function cari1($keyword) {
	$query = "SELECT * FROM datasiswa WHERE
				nama LIKE '%$keyword%'OR 
				kelas LIKE '%$keyword%'OR 
				nisn LIKE '%$keyword%'OR 
				jurusan LIKE '%$keyword%'OR 
				email LIKE '%$keyword%'";

return query($query);
}


// register
function register($data) {
		global $conn;

$username = strtolower(stripcslashes($data["username"]));
$email = htmlspecialchars($data['email']);
$telp = htmlspecialchars($data['phone']);
$password = mysqli_real_escape_string($conn, $data["password"]);
$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// check unique username
	$result = mysqli_query($conn, "SELECT admin_username FROM admin WHERE admin_username = '$username'");

	if ( mysqli_fetch_assoc($result) ) {
		
		echo "<script>
			alert('Username has already been taken')
		</script>";

		return false;
	}


	// cek confirm password
	if ($password !== $password2) {
	echo "<script>
		alert('Passwords did not Match!')
	</script>";
	return false;
		}

	// enkripsi pw
		$password = password_hash($password, PASSWORD_DEFAULT);


		// insert akun ke db
		mysqli_query($conn, "INSERT INTO admin VALUES(
			'', 
			'$email', 
			'$username',
			'$password',
			'$telp',
			'false'
			) ");

		return mysqli_affected_rows($conn);
}

// // // // // // // // // // // // // // // // // // //

// funtion upload
function upload() {
	
	$namaFile = $_FILES['user_pfp']['name'];
	$ukuranFile = $_FILES['user_pfp']['size'];
	$error = $_FILES['user_pfp']['error'];
	$tmpName = $_FILES['user_pfp']['tmp_name'];

	// cek user_pfp
	if ($error === 4) {
		echo "<script>alert('Silahkan Upload Foto')</script>";
 
		return false;

	}

	// cek ekstensi file
	$extFotoValid = ['jpeg', 'jpg', 'png', 'webp'];
	$extFoto = explode('.', $namaFile);
	$extFoto = strtolower(end($extFoto));
	if ( !in_array($extFoto, $extFotoValid) ) {
		echo "<script>alert('Ekstensi tidak sah!')</script>";

		return false;
		die;
	}

	// cek ukuran file
	$ukuranValid = 500000;
	if ( $ukuranFile > $ukuranValid ) {
		echo "<script>
		alert('Ukuran Tidak diperbolehkan \n<5MB')
		</script>";

		return false;
	}


	// upload img
	// generate nama baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $extFoto;

	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
	$lokasifoto = '../img' . "/{$namaFileBaru}";


	return $namaFileBaru;

}


// tambah akun user
function tambah($data) {
	global $conn;

	// ambil data dari input 
	$username = htmlspecialchars($data['username']);
	$password = password_hash($data['password'], PASSWORD_DEFAULT);
	$email = htmlspecialchars($data['email']);
	$phone = htmlspecialchars($data['phone']);
	$pfp = htmlspecialchars($data['pfp']);
	


	// query insert data
	$query = "INSERT INTO user VALUES
				('', '$username', '$password', '$email', '$phone', 
				'$pfp') 
			";
			mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);

}
// ubah profile picture
function ubahPFP($data) {
	global $conn;

$user_id = htmlspecialchars($data['user_id']);
$user_pfp_old = htmlspecialchars($data['user_pfp_old']);

	
// cek gambar baru
	if ($_FILES['user_pfp']['error'] === 4) {
		$user_pfp = $user_pfp_old;
	} else {
		$user_pfp = upload();
	}

		// insert akun ke db
		mysqli_query($conn, "UPDATE user SET 
				user_pfp = '$user_pfp'
			WHERE user_id = $user_id");

		return mysqli_affected_rows($conn);
}

// ubah password
function ubahPW($data) {
	global $conn;

$password = mysqli_real_escape_string($conn, $data["user_password"]);
$password2 = mysqli_real_escape_string($conn, $data["user_password2"]);
$user_id = htmlspecialchars($data['user_id']);

	// cek confirm password
	if ($password !== $password2) {
	echo "<script>
		alert('Passwords did not Match!')
	</script>";
	return false;
		}

	// enkripsi pw
		$password = password_hash($password, PASSWORD_DEFAULT);


		// insert akun ke db
		mysqli_query($conn, "UPDATE user SET 
				user_password = '$password'
			WHERE user_id = $user_id");

		return mysqli_affected_rows($conn);
}


// ubah info akun user
function ubahINFO($data) {
	global $conn;

	// ambil data dari input
$user_id = htmlspecialchars($data['user_id']);
$user_username = htmlspecialchars($data['user_username']);
$user_email = htmlspecialchars($data['user_email']);
$user_telp = htmlspecialchars($data['user_telp']);
	

	// query insert data
	$query = "UPDATE user SET 
				user_username = '$user_username', 
				user_email = '$user_email',
				user_telp = '$user_telp'
			WHERE user_id = $user_id
				";


			mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
}



 ?>