-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 23, 2023 lúc 08:21 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `CreatedBy` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `clients`
--

INSERT INTO `clients` (`id`, `fullname`, `email`, `address`, `gender`, `CreatedBy`) VALUES
(17, 'Vu The Song', 'Songtv.bhsoft@gmail.com', 'Ha Noi', 1, 12),
(18, 'Dao Duy Dan', 'Dandd.bhsoft@gmail.com', 'Ha Noi', 1, 12),
(25, 'Le Thanh An', 'Alt.bhsoft@gmail.com', 'Ha Noi', 1, 37),
(26, 'Nguyen Thi A', 'Ant.bhsoft@gmail.com', 'Ha Noi', 0, 12),
(27, 'Dao Xuan Khai', 'khaidx.bhsoft@gmail.com', 'Ha Noi', 1, 37);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expired_at` timestamp NULL DEFAULT NULL,
  `user` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `created_at`, `expired_at`, `user`) VALUES
(1, 'b127e41affa4cfbc9c0c3fc16a56a533', '2023-06-20 10:39:25', NULL, 9),
(2, '5745b8a2193ec86d6fdfe9ed6ac0f317', '2023-06-21 01:24:43', NULL, 9),
(3, '44b93394469b708005dd18e2fac08b24', '2023-06-21 01:46:47', NULL, 9),
(4, '1614353693060a55627b6d0fb5f05fea', '2023-06-21 03:39:36', NULL, 9),
(5, '898f4770dffa899459ac5e1edc87331d', '2023-06-21 03:42:23', NULL, 9),
(6, '3fde00de3dd0473dc1ff45049857c9db', '2023-06-21 03:47:50', '2023-06-20 22:47:52', 9),
(7, '965167986f4988ce777c848084218870', '2023-06-21 03:50:00', '2023-06-21 01:47:18', 9),
(8, '041bad210d4ba8f99ac512d40af49f0d', '2023-06-21 06:47:21', '2023-06-21 01:49:01', 9),
(9, '2b89ebee8a2290af721b70c252c7e852', '2023-06-21 06:51:27', '2023-06-21 05:22:27', 12),
(10, '354e679866cfd036f517d9838291d646', '2023-06-21 10:22:28', NULL, 12),
(11, '62599cfa3fa21671bca1dd49b5778b29', '2023-06-22 01:02:04', NULL, 12),
(12, '0ed3b72eb2ae9da091543110dceedeb1', '2023-06-22 01:11:45', NULL, 12),
(13, '82a5f88536a8c0423cb276936923bf20', '2023-06-22 01:59:33', NULL, 12),
(14, 'ecac6f75bf41fc9b95bfc780ac41a10a', '2023-06-22 02:10:30', '2023-06-21 21:18:14', 12),
(15, '7fb120d4cd4ad7219c14aeed7de0cfc2', '2023-06-22 02:18:16', '2023-06-21 21:41:06', 9),
(16, 'e65b21c7d28708f98b26d8d32fa3546c', '2023-06-22 02:46:26', '2023-06-21 21:46:28', 9),
(22, 'e19d1cbb5fc68eaf422179b29cb37a8c', '2023-06-22 03:58:28', '2023-06-21 23:00:49', 9),
(23, '0c669ad3efbfe69f574b8fe3cb648418', '2023-06-22 04:00:51', '2023-06-21 23:01:02', 9),
(24, '40b0fe6720bed97bc9814fb013829b18', '2023-06-22 04:03:12', NULL, 9),
(26, '33851720605b99d310c39dc8e3096324', '2023-06-22 04:14:11', '2023-06-22 01:21:58', 9),
(27, '738410ee0173dad3db89e7cee9e627a8', '2023-06-22 06:21:59', '2023-06-22 01:22:45', 9),
(28, '443af504fdb516d929a7bf4e3e9396eb', '2023-06-22 08:21:21', '2023-06-22 03:21:26', 9),
(29, 'c2d18b1b3df0da93802a0662edb6ac60', '2023-06-22 09:22:00', '2023-06-22 04:32:31', 9),
(31, '8a61f160768261443a89c24007617f21', '2023-06-22 10:13:05', '2023-06-22 05:14:10', 9),
(32, 'ya29.a0AWY7CkmgslaGwYMBYG6g-8b3s', '2023-06-22 10:14:15', NULL, 37),
(33, 'ya29.a0AWY7Ckk494x78SBYRXqcGCU6q', '2023-06-22 10:19:47', NULL, 37),
(34, 'ya29.a0AWY7Ckn2k0Yh2LvdAXa5n2Lo4ex2tGFGUex557w9YjRdzTC42ftPylbjRnEDwHnuVMfK1dhb3s85kgvvkXHMi5BkrlZI_gZ8XYnLiYrmGrdyL80yU5BIjZ53AKF9rTy8XbEnx3pTK2hUZIJBgOYLvPYv7k_1aCgYKAaoSARISFQG1tDrpuJ5NnEh2Ze0qrNvcru6Nfw0163', '2023-06-22 10:35:48', NULL, 37),
(36, 'ya29.a0AWY7CknsV3DlXpSghUBpFLXYE2ecmvHiOOvIjolgZ4vjp-MmeQNRPAmTkHjzoHud2ri3VDW5ZKYYiLG2CRC6qpGsti6iz41pmGgn4w7ZjBqgZngkT-Z-eSnCMg7T5FbYoaM0WXqMBUMRIbWghfc3_XpV2PSOaCgYKAUkSARISFQG1tDrpdNWGMigL_q3cFybJik9Q4w0163', '2023-06-23 01:48:19', NULL, 37),
(37, 'ya29.a0AWY7CkkYVuymiaP0c0okTxReClMMpqADF31fRdx2FMmImVHOb3u_RIZROb2RYjWgkT_O4vEw-ngYurospElFmwhsyH5R94DYMM7KFxTIX5WvXC9yhDYHXnpilg8gy9TwdHxeLk3QrwOEoprzmO-3hg1eB-LHaCgYKAbQSARISFQG1tDrpQWmU9pIOTZ7IEszAt4XOAg0163', '2023-06-23 02:41:31', NULL, 37),
(38, 'ya29.a0AWY7CkmZQvEQehEIIertth34FpruzW7baJzMfYnnZ09GJx1jqD1SeyGwi5r7Bcsk4_40PGQrqAo_Hw75q9_NdfKW1fivTNmmKW-wGIx_wR1DlhcQ-MGYG5KJe9WGPZC_-65wLtpiEz6XEVgYQ9GXxxCHTb6XaCgYKAf0SARISFQG1tDrph-3rdKg4drm8YfX4LijxIg0163', '2023-06-23 03:01:27', NULL, 37),
(39, 'ya29.a0AWY7Ckl7Awr4ZMrRUOT2-8BF0KPl_vqQTwaBKQRuu2vnUoX-hDBmdOKeR7hSfosT69xvkMZn_a9RUd9wEUpzZlt9O_ZErIzgEzdECj6DOxEJQ1C4Ge7WxPBMvPQaL3qDKhFjZWP0Vj0KWAuYtrY7-5fhoFkdaCgYKAXwSARISFQG1tDrpACycZiGKy1_SulTkCycBgw0163', '2023-06-23 03:06:25', NULL, 37),
(40, 'ya29.a0AWY7Cklp_u2qwRpQx3zRWkrx9fjtkdRle9FsA_5OAe8cl-BKz63pZL3jwsqntDBCpPb_rdAZx-zy4Cv1DECguC_MXARmAupazsT7GGvsVp2OXVcsWtlZYBTPycUC1VkZzoFVCDEC0UBqI0BWh1Ud_hK1tKeCaCgYKAcoSARISFQG1tDrpwo2dvzjAZbiFJaxkvIp7fw0163', '2023-06-23 03:12:16', NULL, 37),
(41, 'ya29.a0AWY7Cklp2vinJFV5zbBjcAShz2V9FFDMLIpMbL6_iiSt-hMnPS82smCWrpV-m-ORPyxapTAj5z7baLRfy0Nz1_zbhc3zWpVbMaaQVX3I4-TsGx7qCxhQQe3JvZEk6cgiaDK1PDlmY9hOGwDrYlm2GNbhkCu_aCgYKAU4SARISFQG1tDrpu97AyNuxtO_lIwYDOHvx3g0163', '2023-06-23 03:16:37', NULL, 37),
(42, 'ya29.a0AWY7Ckm3bHLH3TSqs7kfC80Ax8Jh4iQwIHhqXnKAKEML7Ku8L4NdbMVp-GhkknV_wnPkP6vTUdjQmEX-qT4rC4i_YoO0Pwc-UhE56RaB5CI1pTqG6BhYW8J-zMipgujSTO_MVFNWLIfF4x8Bvt6ViL_evI3SaCgYKAa8SARISFQG1tDrpf62mnJvZdttSjBkY_5R_hw0163', '2023-06-23 03:42:05', NULL, 37),
(43, 'ya29.a0AWY7Ckn94AIphBHv47IaxX3mr4Pv75DgtfhhiBmi5TFBYzslJQlv7uchoIQS9GuuTeEydYK8AuX-1QEKvBnIK9ULzN3QxElWmm-pA9oIlVoGT1rN6a4H9Z-ypL1t8oOQjV0mkibOx9gzSvs_C3Cj2PwYVEAPaCgYKAc4SARISFQG1tDrpnbKuAM5wqQTHVYZ07vHqag0163', '2023-06-23 03:44:12', NULL, 37),
(44, 'ya29.a0AWY7CklC7gwms56AnLV2F905zvZQFvzcLogiIF3ar_U2hR0kOCK-3iLm83GnbxEXrBvzLCJMXtccRYfw4ApvrKdgWMqOdBBscjToe7KEHkXxgV4A1jHdBqtWZ94MQVsyAekANt2qFQlqs5l8M4pE71mwxxTiaCgYKAQoSARISFQG1tDrpaA9MlYwsVQan8uZdE1_vUQ0163', '2023-06-23 03:47:34', NULL, 37),
(45, 'ya29.a0AWY7CkmvgP_s4twU0ufw0e6bRTai_yrimBdkldGVOr0z8A6y5Y0kHx4qZooZxLId7wL1GLaynw9IWJIO01qLepjQXfJiQCb74bE6jvgzKamg1_SZdIoUg4u4UewKzZDlrHs0dujvPwzjWMJIiyBqT1sgdBpNaCgYKAWISARISFQG1tDrp5nzzaCBRFqBCIHf4FnrcGQ0163', '2023-06-23 03:49:06', NULL, 37),
(46, 'ya29.a0AWY7CknYE3GXd3Y6MsTnngQ-jxz0IGmAA6R0INnwI2cX7lq6AyKgXny_eLIsEe4p2YQj6sZjJGA1xuTh0BSwSpZhduNW68OCDeIyzc_IgNL1xxs5pTrIczEKAuSjQ7hejXZssfurfHVrKBjMIVh3nC72XYTraCgYKAcwSARISFQG1tDrpe3ULHvaRd6snz2EHzXoh-w0163', '2023-06-23 03:50:04', NULL, 37),
(47, 'ya29.a0AWY7Cklu3zzesHzKQC2CLRaYouCSpIVh0iZxxTk8Ox7sZrP5btZR--FNtNb14O92Rw0koxMLsHt4v_x-m10U2LDbVtqbeA0cEPOI7OXXkwEQx-hIsLQkR-tErxPvBEdZcNKTs_qL7OjcLI0WmNFHBJoz0EABaCgYKARASARISFQG1tDrpU6Bx69qXjRv-PuJ4ghVoIw0163', '2023-06-23 03:50:17', NULL, 37),
(48, 'ya29.a0AWY7Ckl35uowROV5wAINSEW83p4O4t8JdmM2_zPSszGuw9dSDG0Bd5aevOOVQArgwGFhHYwi7jtwo1lqSSjz43NEUvTHL9zhfWwi1qz1CesgnfyvY4vEzeLHoNuOxjR9Q9EasLs0CunjiN03qr9_SGpz4xbeaCgYKAVUSARISFQG1tDrpbRc4kl-1dWzlNwoEdh0HwQ0163', '2023-06-23 03:50:24', NULL, 37),
(49, 'e490777f3ffc1295ab1c8f5d1efbdc55', '2023-06-23 03:52:08', NULL, 12),
(50, 'ya29.a0AWY7CklLD0w3fC43VKhp3IwvCoMkvFquBS4I8wMvEQLWDbVDooOr6ktAM1u6XV1RiQvvr8LVxpw7wVNkC2O60H9KLafWwREe1dXw598bO_16PPmdDYbMXyuxTX8CAbsv3FGHqsko2pdgfG_1Os6O-e4IYrmEaCgYKAWwSARISFQG1tDrpzv7FIy4gtqO4LA6u846KOw0163', '2023-06-23 03:52:22', NULL, 37),
(51, 'ya29.a0AWY7Ckm70xuv9fqHWDZA9qCict2hUvJKSlEghA2SS5w6ysVSbjrhHBiBaKGAdtnPNl5UE-j4lQR5PZn5enFbVB38KM0RIBOqNd9QbKAZJRX7sClYfBeuxPDZVKV6eQM-7MWyDkkg_NZSIlWFzPL_nMfAJa1vaCgYKAY0SARESFQG1tDrpGlzCnf2PoPjFkhmxKObocg0163', '2023-06-23 03:56:26', NULL, 12),
(52, 'ya29.a0AWY7CklkYu7HJx_7SPx8z_4KU-ltb2gSRV-evTMV5gML03OC-UVrZktxt9ys51NNK98v-BuHPWqmJn3rr21yLK9LiH7MgIksrCjSZCx32CHuidN196AxkoOaDvOD1sUBKkUd6vIVfBgGSgZosoNVoJX_PIKZaCgYKAacSARISFQG1tDrpe2FcVcGjyFOkeH5cx--Ugw0163', '2023-06-23 03:57:31', NULL, 37),
(53, 'ya29.a0AWY7CkkiTFzi38MrE7KBfajYyI2h0bQlat4v4ThonAfAseKumdKjxOcS_mSeUqmZSiMdrciKP6k1wYSbZa-iG-M1_vpzR9L0Yb_ROMvJdZP9UrKXAQPti1TW6e5T03TYM5m6QLqDej5HJOP9hX-_yTjYmHEjaCgYKAU0SARISFQG1tDrpTTExegi5G69l0wCWNT-mjQ0163', '2023-06-23 03:57:43', NULL, 37),
(54, 'ya29.a0AWY7CklELEWaaMHyG-ozK0rukfvScwuEWqtLqGq7MA3m9rgomNd6vYk_xFjKcR33E6-GkOeYpY1-zIgVM4vRciX7jW1yf4vW04xW7SfRaGxxudNuFGJ_4e2RCeV2hwoprElOIZGJRhe5ca6iCxUJEZcZkqgyaCgYKAQ0SARESFQG1tDrpEAsYIUdDskVqeen7d_BSOw0163', '2023-06-23 04:08:43', NULL, 12),
(56, '5cdcdd5f1a9ab72715e0dedfe1a70dbb', '2023-06-23 04:26:26', NULL, 40),
(57, 'ya29.a0AWY7CkmL-asiELfrFWoydtThMMjyYL-eRGPHiTynGSWqn1mpSj1tlfpDb9SfDTCbbJyZWCyeNulut4X85-2xVtWXUGwa8U3mgaFtST7qVAoKsUs7fWBoHhhjd_fcyN7FME4-pWoN0INBrtbKHJvV8qxemwpQaCgYKASYSARISFQG1tDrp1qZtvsVWrK4vAPM4YO04ZA0163', '2023-06-23 04:26:35', NULL, 37),
(58, 'ya29.a0AWY7Ckl9v6gcV2T1A9DsZPM-wtz4DrEL6RXWuWp0scGcakhjzeDC1oInBUkByixTXboiXKUpfKGXVwSmd0ph1FmaRhey6TDpuCrSinVetTQff-LZQnVIl63gOqIsBus2qxVhEnVO1_SXjN2Z7K8hbiwxIt1baCgYKAcUSARISFQG1tDrpfsRStXb2yXwOo-04IZve7A0163', '2023-06-23 06:18:40', NULL, 37),
(59, '09f436ab419f9d7f3366e4f3818eb432', '2023-06-23 06:19:07', NULL, 40);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `fullname`, `address`, `password`) VALUES
(9, 'Daodan2001@gmail.com', 'Dao Duy Dan', 'Ha Noi', '$2y$10$CQnFpI2ffn7F/xhisAoIjeVu0ZuHQFSvTLEqOE.lgt3lJ6WZRRprq'),
(12, 'Daodan2612@gmail.com', 'Dao Xuan Khai', 'Ha Noi', '$2y$10$rIjJyXl01QwkXoduHn/j9.dP/pLwMYhfw5hTycR/jAiEGU6Mp.cO.'),
(37, 'dandd.bhsoft@gmail.com', 'Đán Đào Duy', NULL, NULL),
(40, 'Daodan26122001@gmail.com', 'Dao Duy Dan', 'Ha Noi', '$2y$10$wC.SzxpbntRCDmJuAeRC2.SrCFIR6dQCkZjC/EESTBE.NasCuuns.');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_clients_users` (`CreatedBy`);

--
-- Chỉ mục cho bảng `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tokens_users` (`user`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_clients_users` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `fk_tokens_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
