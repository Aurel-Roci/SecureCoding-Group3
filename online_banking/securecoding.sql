-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2015 at 09:13 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `securecoding`
--

-- --------------------------------------------------------

--
-- Table structure for table `resetrequests`
--

CREATE TABLE IF NOT EXISTS `resetrequests` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tans`
--

CREATE TABLE IF NOT EXISTS `tans` (
  `id` varchar(64) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tans`
--

INSERT INTO `tans` (`id`, `user_id`) VALUES
('7InXU4jUuSxya58', 1),
('7LcXs9CSKubXnn4', 1),
('DKYivctsHddfU5R', 1),
('ozCFgkn6DYHsKfE', 1),
('uKgGHIQjAAOLyb9', 1),
('yPELdbWuJKyGRCu', 1),
('0jfUA2pcqFO4gy0', 3),
('1lBUtMHjg2BibLU', 3),
('2DTnlEuRauHZfG3', 3),
('3IHe950ds2wYOqL', 3),
('4z2cztjcrNFnlKk', 3),
('5QzrNEus1kTFs0N', 3),
('5RWvjqP6WnUkTe5', 3),
('6sRye5CDzwSuktL', 3),
('71Vf0jqnxOM3eJw', 3),
('7dAY57lU7uFS96L', 3),
('8ko3LNLSkjL8eWg', 3),
('8vrLd4puTfUOAhW', 3),
('AAhgIdp5Bo2r38I', 3),
('Ay890VOunQPhvii', 3),
('BB1Ft9pu70CLZNM', 3),
('BlvTCe62kHrm9uu', 3),
('BzoTl9pOt0O3HHl', 3),
('Cd4xt4QUsoIfrXZ', 3),
('ceMuUsj0gHJo4cQ', 3),
('d2jIeGy4xg5SG6t', 3),
('DKiAfC05IXtCimR', 3),
('DRlW43EnPrD868g', 3),
('dvbr9AVp1unpwY5', 3),
('dwhFFO5OoJ8nsrw', 3),
('EYFdq0eE3ya9uXq', 3),
('f011uWtNWJuG8zS', 3),
('f42vYCxnOX3D1jc', 3),
('ffs9wp8zDkZJj9W', 3),
('Fmb4fxdFlHGaKnS', 3),
('FOJO3oQb1h3yX4O', 3),
('fyT7bNQtki189Cz', 3),
('fz7ZnbnenovqWtv', 3),
('GAZZphBivaTgc52', 3),
('gCTgXZ2dbq6Y9dp', 3),
('GFPW3BPGtLC38WL', 3),
('GORvLV7BBAmeDua', 3),
('gY7iB417bxv1tTw', 3),
('hHWssN9EFA825f5', 3),
('hNPPQFDJffp3DFn', 3),
('hPIcC6fYgYRq38k', 3),
('HvG8V9noYWQF5hu', 3),
('hZvbmQQRI0lp0A6', 3),
('I19dMA8NDlkQs8f', 3),
('i1c30ybc96vWcop', 3),
('IVjdHIiLMgjFu7N', 3),
('IxsXE9PS6Fm2nh2', 3),
('jHlIK7wwZQPLY3I', 3),
('jSpNShK2xbkOfn5', 3),
('JSzq7Jw7WYatWZT', 3),
('JULZl7bBVjN5Sti', 3),
('k4y2POTzCFNnfkm', 3),
('KsvKrU12dxd7Npc', 3),
('KvOHzhFSsNhhf63', 3),
('LhX4tXib7oOsOLm', 3),
('lPdDptfqzYn2BGp', 3),
('M4RCTIixsxNRAqw', 3),
('m4XpUk2d1RYvm6l', 3),
('MCILfQKOMdKzwZR', 3),
('mYTgMvCngCEBKW2', 3),
('Na2PnCjGPKuu8Pf', 3),
('NBTncRzXgDRHMNX', 3),
('nmUrpI6wxTOVb8L', 3),
('nTLOAJvPWRqPUbt', 3),
('numyVw9QValjzSi', 3),
('OqbKQGcRqunv72P', 3),
('oqEOdw5XzC9Trph', 3),
('Osib0eH95DkqXTi', 3),
('ovf7HRdWQtVHUZQ', 3),
('pa4R8J1YB8EYa1f', 3),
('puUMn2l9JTa4hTc', 3),
('PZxoVOqWWnqs19q', 3),
('Q8TNBlBLZgl8iro', 3),
('Qqyrk1e2kv5VNhH', 3),
('QvRRwmO09LKErTe', 3),
('RKyWh208WtwEIXB', 3),
('s2hMLwsjB0AGShM', 3),
('S2zBYbLo4Tq8WgU', 3),
('s3idSTXoJUg9Jal', 3),
('SSgoLSCSVWzmjIR', 3),
('TYfrmbfN8cayFcH', 3),
('tz0l5MgcnSMJ7qe', 3),
('u4prukMwxOnwkKC', 3),
('Uw32OF7PMinhjQb', 3),
('uYYD8YyWtWMjehB', 3),
('Vi1CWJw6wnQWouN', 3),
('vMqqsesPzsG8qPR', 3),
('VoWqvr0Jiv5DFj8', 3),
('Wr9eE28CqRwG1gR', 3),
('wUrHYGfcmAT2LEq', 3),
('wwv7vAeQull9evg', 3),
('wzDIDDgOPpVlm7J', 3),
('X0nwrufXCcVMGSM', 3),
('XHuMo444XxSeO8k', 3),
('y5JVCaqS7243PLV', 3),
('YqiOhCTeyBK1bMP', 3),
('YV80q6DYusVx5XR', 3),
('Zbt0RW9grhh43gR', 3),
('ZJnT7zLHx1loI7b', 3),
('ZLQRj4WWHwsA1N3', 3),
('ZTGDHTaMRKp0DRp', 3),
('0aux31oWiYRdOF2', 4),
('0mFeR0f43vGgz1N', 4),
('0nLqIxnJuHsL85K', 4),
('0p15VQ6TTdftzG2', 4),
('1257jc6hNj4jX6q', 4),
('1qE4pkEWL7uVdaL', 4),
('2b3qf1YraCzphI9', 4),
('2IiH29yHxGS1yyj', 4),
('2uMHzb1d8NkCJxN', 4),
('3WwEKjznrHcs8LJ', 4),
('4VeNXizTO70elxN', 4),
('4WaC7Eqk7FHcuuy', 4),
('5fAmblyhw5JuOz9', 4),
('5OIaOTBVxZ4uqeX', 4),
('65DdiVfUJIZl3AG', 4),
('6K7ma8a4U621vMF', 4),
('6TtI5ssyZpbjCXF', 4),
('73yatNcsfn4OMmw', 4),
('7o9GlqSMjIXG5vD', 4),
('8WJ14LWwx6pexz1', 4),
('9MTDjXEITWGKavq', 4),
('9ZvkvGanHk6UHop', 4),
('Be83vYyUmJSrOR4', 4),
('bG3IemyYKGwsTm8', 4),
('Bp1Y8f5b2AGxgDb', 4),
('BuzXgcrTPbmmxXR', 4),
('cE7eDgtJswj93AN', 4),
('cEAQtvAdDtMibtv', 4),
('cp4wO1X27mAmqyM', 4),
('cu8Rg0CulVI6qfs', 4),
('czmJd72NuuuGXDs', 4),
('dj868UA1vauUccC', 4),
('dJisXeqclQ1VqdY', 4),
('e6HKmI5UjEj2lmT', 4),
('Fb5h7ZXAcNvE27O', 4),
('FDZjRhf7bZQbkUL', 4),
('fj7dh1BOt5BlAlo', 4),
('FlxjkPkdbSiLfzq', 4),
('GAT82UrLaSGq9NZ', 4),
('GMeAqyx5gq2Xbcs', 4),
('GO5PGmQiQbeyiEO', 4),
('guANNVD78O0qzg0', 4),
('h9FLSKekjdKvxms', 4),
('hrEPVJK8TyEIGdS', 4),
('hYJUkxmuSB4jfFk', 4),
('iD034IBss59URh0', 4),
('IhjoWqd6oxe4YqN', 4),
('JkYYUowrtMRvK3I', 4),
('jLD1PNwMr6p0y3v', 4),
('JMCmOs9keArEA0H', 4),
('JtEkQQFo8btSFhr', 4),
('JuWF8Q0fPTC8Xbb', 4),
('Jw1zvzLU0JC9F1n', 4),
('jx3rMGHgpaMJjQj', 4),
('kfIvRQ9iahYRtsl', 4),
('KHEMxsK83ksMxdR', 4),
('Kkg6OhBdS78D7YC', 4),
('KlSPLuSBzsp1HHN', 4),
('kpBWTFtdQUreB9c', 4),
('KygWKb5bxrXJPFl', 4),
('lFzSdniLrLn0Wf8', 4),
('m3H3auXDACzrEuf', 4),
('Mfgq1NTMWX6oKEC', 4),
('miuwYqtxXmEujgr', 4),
('Mkxu5UcaOwO8zau', 4),
('mTmu0uoAwUL0PYc', 4),
('nPeeVYe7pPzAb3L', 4),
('O04Zbr7En8WrasQ', 4),
('ORQYxboqYI9Woer', 4),
('PrqkMW1WkIhqDYP', 4),
('q9IrdN9OfCUpxLG', 4),
('qDVEUk6YTnj4y2M', 4),
('qfklWKMBJ7Drl5Y', 4),
('qlawaQS09Icnhu2', 4),
('QXlMCuDDJsxmBvy', 4),
('rk8d1Ho2UxQe9zM', 4),
('rZBt4xkardoGHXn', 4),
('sbwxiQKo7xHcQFj', 4),
('sHrr0jJgqVfh6zb', 4),
('sTevk0c2gCd3lxT', 4),
('SzR5J0bqArbmub6', 4),
('SzxxOpy3tBzaS8c', 4),
('TsbcU9qllMbnHCA', 4),
('U6Y2jZKI2EfSTps', 4),
('UuxSwRSgAVVPOOf', 4),
('V54pB3Q5ANrfhLv', 4),
('vOFF7O9Xk8GqbIM', 4),
('vR2dnU3xcdOb5hD', 4),
('vs2QOYABzjIcL4i', 4),
('W4EYi1Sly5zmgFE', 4),
('W63YFzxrtxa5GP7', 4),
('WBn3Yyc8D7fF9Kr', 4),
('wUG6NTt5FVR2VNh', 4),
('Wzaam8tW1i31wpz', 4),
('X8sgPupnbX44ZDC', 4),
('XL9FVXzxS7wXBXb', 4),
('xmVGqqFYl1Idsw4', 4),
('xXegos4ygkabJIX', 4),
('ye9i8uQvYI632lJ', 4),
('ZTwg0kxBypJH3QF', 4),
('0QQjfiSHh2SOC3H', 5),
('0XLV5UZhrcbU7w2', 5),
('1qeNjRTuHhJSjM1', 5),
('28vMAuwYrKeMHYq', 5),
('2iqy2LL4Hz5vYXZ', 5),
('3gEz2f3zdvjrh0q', 5),
('4Eb7nqtVoeCUHvh', 5),
('4HEHaoZT3T2iXdw', 5),
('4jO4wfnAzcnbK16', 5),
('4MJnPJDdTC0TUif', 5),
('5HLobFuAuABy96T', 5),
('5p5p0UZlhU0qDhM', 5),
('94mftmatIrnIS10', 5),
('a1zw8PdeAwr9Vnb', 5),
('B6KSmRtlqYDP8jW', 5),
('bD3c8bO4uflx8o7', 5),
('BDU3FTdTxEsNiqm', 5),
('bMwO7GcFiuR386H', 5),
('C3opUCniec2F2oK', 5),
('Ccaw93n9IWIrELD', 5),
('CqULykeai49QMjA', 5),
('D6DlanxBicLEfDS', 5),
('DA4RJiA7VV5JCfi', 5),
('DbbzYJymZ3WqGkC', 5),
('DcGOMEyk0xnXY4h', 5),
('DHHigKxkjLPCd7D', 5),
('Di5MyNu9Im3JoMw', 5),
('DKSHvJFknNtpznZ', 5),
('DPJLdw3YieMYsTC', 5),
('e1S90mq0eru7TiI', 5),
('edz6h3xzIyqZkYN', 5),
('EjIcoDUMFzxkr17', 5),
('EwdqH5YM8kJELkD', 5),
('FDb335GqoUDqzGP', 5),
('FEjtT6pP513yulb', 5),
('gaNQeYoBOJrQm5B', 5),
('gDq22BHwcb7OKgU', 5),
('gtfwXiEMtcjNITe', 5),
('HuI4KbrUF9m2Se4', 5),
('I2wKld1VN0NpSuE', 5),
('I58nMiLMbOGd6Dr', 5),
('IhVYtg0R0uTsNAs', 5),
('IIERLcosDHPFyv8', 5),
('iPtmHcFhjAdpkPF', 5),
('J0gg6AYzuioaF6M', 5),
('J7x5kIsTjPGnHBj', 5),
('JdCsJiJFT8e4be6', 5),
('JHtWV5ETnGfrc16', 5),
('JO0v7CWjqg2T3zF', 5),
('jwLTD5bPofa129p', 5),
('JYOfMVVZBetthCA', 5),
('k1mcbmzBnN3RUWa', 5),
('kad8eJoCkYOH9yJ', 5),
('kk83xxGrjm1QGtS', 5),
('LCi30fn9ZN0hhly', 5),
('lUceBHXh2l4vLES', 5),
('lV9gHHAVST01JMl', 5),
('LxrY58zuiukr40I', 5),
('MNdxGApaVP8zFhS', 5),
('mwWMyYnfvArCobS', 5),
('N3ztRm8qG9Y46W8', 5),
('NmnzP8g7isDE1km', 5),
('NS3KQYPE792MTzn', 5),
('nSyz0VZuRnIuiq0', 5),
('O8wZcz4T0tNETnk', 5),
('OFA4bxmPkQ2DELx', 5),
('OliorzsZ9bxzaSy', 5),
('opWYV5N8jnFKxB8', 5),
('OvV3WNnuecmblEb', 5),
('oxLiBrbOkJtMwMc', 5),
('PIVpypV8DzCqROT', 5),
('Pr97qsBYQZxH9Ks', 5),
('rAcowbhyO3X74NC', 5),
('RfBX1aKwjtTmdh9', 5),
('rkhYjuynnzRadKy', 5),
('ro1iHhAAYRCRGeV', 5),
('s1WWYS1CMoj1Qv2', 5),
('SWaW9i7XnBcI9l7', 5),
('TdR3triE0QhMyNF', 5),
('TpJsYJnXeflWJDn', 5),
('TTA6khci4kDNZo8', 5),
('TxjAPAlnUE8JhmQ', 5),
('Tzft27PbywkwAqs', 5),
('udMbRx42mWwqBZW', 5),
('UYy5UHn2FLESuNd', 5),
('vE9gAfazxCLIwTf', 5),
('ViUWSRZEyzJI2b6', 5),
('VZGELTaORt3Eswy', 5),
('XAPGXFqASjdSc7b', 5),
('XCU783bwcTsVl7G', 5),
('XphnXk9JpQiulhr', 5),
('XSl7fH6LjczoW1v', 5),
('xtgbl1nJu1rjH0P', 5),
('yCs2Z9eEryfEYzu', 5),
('YD0cqj4kOMByEVl', 5),
('yHLtLHh9cwmyHIc', 5),
('YY1AW3LHz5assnK', 5),
('zfIvFgVBpza2Z2R', 5),
('ZM9nlZvC6N5Js64', 5),
('ZTeqSkyrORW9i09', 5),
('23ji2sNnVYIyb7s', 6),
('317wz07Z251Jev7', 6),
('34upcqmajbOtAgV', 6),
('3sdldSn7eKmsXpT', 6),
('40dmcI1TtM0dzYN', 6),
('4H2QcGFEG5n0cIT', 6),
('4ln6cAMRetXCtal', 6),
('57fbzJLeSj7cyE9', 6),
('6a2Y9eGNL1h1xIP', 6),
('7nwFpZ9o2HDGqjw', 6),
('8xvQAPVRFiAOhgq', 6),
('9hy1stZ2yeEJGPx', 6),
('9VhbvEGLL7KNXzY', 6),
('9W22JbRcmSHdgOQ', 6),
('A5XTAlhmD9z5ey9', 6),
('azS3xFsbTaR71FD', 6),
('B6m7WXXSODapsrF', 6),
('b7ewMxsSpt2g4yt', 6),
('Bx0rTOfJvNP17VI', 6),
('cAVvo0yw3KSBb8O', 6),
('Cy23teGYcaHEC3z', 6),
('czsI9eUgMlsbMA1', 6),
('d74Oh3sCsvhlR9t', 6),
('djiO5372clyqfc4', 6),
('dJRYcHEwlugvrNx', 6),
('f7omkB1gKjagctu', 6),
('FnVcg6rBOl59IkB', 6),
('FsyUYkrqdRTg8YO', 6),
('fwUx39pnkujcfYy', 6),
('g92oz4ukx0jSqyl', 6),
('GFMpYsTJhOLZalD', 6),
('GiKsPFkEQJaWx1X', 6),
('grBaZEko2ETmR8k', 6),
('HrSN8Osb1vRn7CY', 6),
('hyOOddOmBQ4fxuy', 6),
('IA7K3XmBhjGBzFm', 6),
('IhLE6vsqEQDZTk9', 6),
('inDqUcq2bt8dcmJ', 6),
('iy7dcEV8hUwTieB', 6),
('J25HVF2d2GmCLBb', 6),
('j26eenkGY814iKo', 6),
('JeRLdhfVTVoTrXB', 6),
('kFYl7S9nCFarHin', 6),
('kzrKRtoATcDuP9F', 6),
('L5o1gXK2cDljQUY', 6),
('lLN0K8HklRPNddf', 6),
('M3NDthb2OgYJKYh', 6),
('m9MxURObpw6NR04', 6),
('mB1GT38Hr3F9BRh', 6),
('MEWDqaVG5PCuJ3r', 6),
('NP1zmvg6rY1PPap', 6),
('nSLuDPr0qJj7lTM', 6),
('o5hxfRja5WSKEmB', 6),
('Oa4mSl6jEIeJmno', 6),
('OCqi2DJpO2ACvbT', 6),
('ODqQFa2wmop3CGS', 6),
('oHscvFpj2197gGB', 6),
('oq6rtzF9ySkfxWi', 6),
('oZWPKNj8odk2Hab', 6),
('p51mJsxE8DtK7cO', 6),
('PDSbVXz4eCbraNE', 6),
('PE3hmcvhtiCVtpw', 6),
('PK425iVtp9eMCcb', 6),
('pkiunoMiRcr5Z4h', 6),
('pN9uBrx430Allsu', 6),
('Qa9MGxNf4Q0Wrb4', 6),
('QprerIbbKoP6HF0', 6),
('qr2tPBxkW5kgYKO', 6),
('qZvzLc7yrbor8QC', 6),
('RLjTKs8qgTsxVZg', 6),
('RNwTaflITtlnesA', 6),
('s0352zRtVfbSZyL', 6),
('S15RTnbmHMAkx49', 6),
('S77q16LtwYkpfsn', 6),
('Sd8azMUdCHFItQy', 6),
('sKALKjX8dveUEE8', 6),
('STfY8ultbkCdpUX', 6),
('tVZRiktjAdCLuPe', 6),
('u11znUUteyctiyQ', 6),
('U3MxuGJVIVoQ8Ad', 6),
('UQi0IboUy5G9ped', 6),
('V8UExIVDYnBoHHQ', 6),
('vASXNoDdHGeRNvy', 6),
('VcWkLXDn7CrkiFa', 6),
('VfEZlHzcavslnrU', 6),
('vPkEjW6R19RBvd3', 6),
('vUxIhJqiCU5D8EB', 6),
('wJJpNg5fsYqk6rZ', 6),
('x5qUbDuYuJrrlVB', 6),
('xb2ZquHCFs0vzIa', 6),
('XEhKE2Tmnfdc2rq', 6),
('xkoy1iC9Z3dFdPw', 6),
('YDRpuxzw4VVuZxa', 6),
('YjAUEmShK0UbkcR', 6),
('yxtxSBq1Y2H8uor', 6),
('z0hmEKDPNr5LbQK', 6),
('Z2I3j5gPmJ8ZFCo', 6),
('ZMJjFtLOU1ImzEm', 6),
('zoPmONPHx6wj5GF', 6),
('ZraK5hgxHVolUhF', 6),
('09LYYKJ7GA53TaO', 7),
('0HTfhTrwdzXKeOe', 7),
('1TeRSiV9Ff2Cxg5', 7),
('4rPY43gnkTXidsf', 7),
('54vUCot3O65QQEX', 7),
('5okERObVuU9zCFM', 7),
('5WBEwB5ld5kTfHd', 7),
('5zBjTUTp394bagk', 7),
('64ZQH7myPPGbVco', 7),
('6tMmWuEwzxwKG4t', 7),
('7d9yxlRG4z2Q5wb', 7),
('86baVFTpKuXokll', 7),
('88AYX4btq1Dj4dZ', 7),
('88djizw9gE70c9f', 7),
('8NSPjUZDftM3JIe', 7),
('8ylFT8HVKdpNTDs', 7),
('9zRoKSx3AB7w5Ym', 7),
('BDXQXS1veFjm8c0', 7),
('bIxwEBx82o8i0KZ', 7),
('bsBXrAHbHoLMrFX', 7),
('BzGmYDSoSpe3k2S', 7),
('c0GxFylQuQLDqnj', 7),
('cfD7XDiVdcwpWlk', 7),
('CJPluGNuqr9KC8n', 7),
('cjTxGNt4ISSvblf', 7),
('cSkenHRCDvdpORC', 7),
('cZpLKb7Z8OJgbDk', 7),
('d0WKxAm4JptRItC', 7),
('DIHS5zy39pI72ax', 7),
('dRnOwUqBgEHBxWi', 7),
('DwgRoF2khHHUZoB', 7),
('E7PFggzICCPeIzn', 7),
('EMhJl1c14F7drQ7', 7),
('EWsgMsblvbF9UAB', 7),
('exlV40uqRZgCCGZ', 7),
('F22vsOjlOtKMn9z', 7),
('F7Ihkg20otef0IX', 7),
('FEWD27nAq5gxyeP', 7),
('FNhFEZN0yDQeOLr', 7),
('GB2PtIu5BxEPoW9', 7),
('gLdEAJz0lPE3rc0', 7),
('gpJI7m8I04xkkIM', 7),
('GuPyTzqqC11Ky7I', 7),
('h0SyKezXgDDnR4e', 7),
('HdUDYselwXKZPst', 7),
('He2nA10tpSTEWdG', 7),
('hfoZ8uzGxI6fQ8p', 7),
('hI2vnDfWDALiEdu', 7),
('hrdRpaWBEnCiGGw', 7),
('HtkAJCub8IL5tZU', 7),
('i85yJtF3s69LJUU', 7),
('J2OgSOxpd3O8xQE', 7),
('JG7OYfwERh9z9u8', 7),
('JLsHCqAEVPjfbrr', 7),
('Jnu4K0i1pVmYETH', 7),
('jvzLLleXHK8mT3X', 7),
('JXCP0Uz20kDJUsh', 7),
('KczA0qOC0YF9mkq', 7),
('kwlnUWoUpONisKv', 7),
('kzd2JBSf8pLKuCG', 7),
('KzKC8vRHt7l6vda', 7),
('lAOspNHVrzdB8m5', 7),
('LC52iK25KAJAPxm', 7),
('LckmwdhpDkyIwIY', 7),
('LUfnRGXzRFXCrpi', 7),
('Md4h7HGBLuIRlzv', 7),
('mmTDeiigCAXkuXI', 7),
('NdEwXzcbaoZi7x7', 7),
('ntZAwIcoXlNJ6hm', 7),
('NzCcyKG8reRxtHF', 7),
('oIb9mdRG7XKx1eh', 7),
('PdhNZpFn3unBJfk', 7),
('pFH9oPvxxwC4QWN', 7),
('pKUIIdScFzwji7L', 7),
('Plfa08jI43WtRP6', 7),
('PWzttw3GId5Iwcg', 7),
('Q8JLRrZJDFjaYCh', 7),
('r3vIRu8wRb1fNKv', 7),
('raXLKGnfSwXDBqC', 7),
('SewQ0hxowpUt2wU', 7),
('SkUHZbYzUAcJOVi', 7),
('sQLE1HjU64p3tJp', 7),
('svGv19kku9OfVbo', 7),
('T58SGFBS3zeQik8', 7),
('tAjYjatrHkDIArs', 7),
('ufPPudwmPaS2zGT', 7),
('USLpWvpfxPbUOPN', 7),
('uSYL7SnDO0yeSIF', 7),
('Uz19qTrm36B5J9m', 7),
('v8QqLOS09pXTpMm', 7),
('Vj1OQIBjMjcFPn0', 7),
('vsxlN22Bwt3FeFN', 7),
('vVqjbi8IHmMwukn', 7),
('w3gsHiA4S0a9xIn', 7),
('WTfA0cej8rwERtZ', 7),
('WyJJVFeAcO8IyPN', 7),
('xChfUBvWCUpRaqA', 7),
('XpYnbJyiIG6sXi5', 7),
('ZpPOReBza38nEhJ', 7),
('zzgBn6jZq6jCL80', 7);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `approval_date` datetime DEFAULT NULL,
  `description` varchar(200) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tan_id` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `sender_id`, `recipient_id`, `amount`, `approval_date`, `description`, `create_date`, `tan_id`) VALUES
(2, 1, 3, 100000, '2015-12-06 12:54:46', 'balance initialization', '2015-12-06 11:54:46', '7LcXs9CSKubXnn4'),
(3, 1, 4, 100000, '2015-12-06 12:54:48', 'balance initialization', '2015-12-06 11:54:48', 'yPELdbWuJKyGRCu'),
(4, 1, 5, 100000, '2015-12-06 12:54:50', 'balance initialization', '2015-12-06 11:54:50', 'uKgGHIQjAAOLyb9'),
(5, 1, 6, 100000, '2015-12-06 12:54:52', 'balance initialization', '2015-12-06 11:54:52', 'DKYivctsHddfU5R'),
(6, 1, 7, 100000, '2015-12-06 12:54:53', 'balance initialization', '2015-12-06 11:54:53', 'ozCFgkn6DYHsKfE'),
(7, 3, 4, 1000, '2015-12-06 13:06:56', 'transfer', '2015-12-06 12:06:56', '0jfUA2pcqFO4gy0'),
(8, 3, 5, 1000, '2015-12-06 13:07:25', 'Transfer', '2015-12-06 12:07:25', '1lBUtMHjg2BibLU'),
(9, 4, 6, 5000, '2015-12-06 13:08:33', 'Transfer to demo4', '2015-12-06 12:08:33', '0aux31oWiYRdOF2'),
(10, 4, 5, 3000, '2015-12-06 13:09:14', 'Transfer to demo3', '2015-12-06 12:09:14', '0mFeR0f43vGgz1N'),
(11, 7, 3, 10000, NULL, 'Transfer to demo1', '2015-12-06 12:09:53', 'zzgBn6jZq6jCL80'),
(12, 7, 4, 6000, '2015-12-06 13:10:13', 'Transfer to demo2', '2015-12-06 12:10:13', 'ZpPOReBza38nEhJ'),
(13, 7, 5, 500, '2015-12-06 13:10:48', 'Transfer to demo3', '2015-12-06 12:10:48', 'XpYnbJyiIG6sXi5'),
(14, 6, 3, 3000, '2015-12-06 13:11:18', 'Transfer to demo1', '2015-12-06 12:11:18', 'Oa4mSl6jEIeJmno'),
(15, 6, 5, 3000, '2015-12-06 13:12:07', 'Transfer to demo3', '2015-12-06 12:12:07', 'NP1zmvg6rY1PPap');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(64) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `memberrole` tinyint(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pinHash` varchar(100) DEFAULT NULL,
  `lastUsedTAN` int(64) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `approved`, `memberrole`, `email`, `pinHash`, `lastUsedTAN`) VALUES
(1, 'admin', '2df84a679ae22f29fcf4db23ec02d318e61e16e1bbe36a7aa3136a516febb611', 'Admin', 'Admin', 1, 1, 'admin@amdmin', NULL, -1),
(3, 'demo1', '500a22a913191b83b6f87c16d46e80818c63fcb3b55c47b4a3a804ec40f232e8', 'Demo1', 'Demo1', 1, 0, 'demo1@demo1', NULL, -1),
(4, 'demo2', '0816701f7887407dd46154bc48a40d8fd8d1efc6ffce1169e6a529c089d86d35', 'Demo2', 'Demo2', 1, 0, 'demo2@demo2', NULL, -1),
(5, 'demo3', 'dcd2a67f356abc6ed31521e7525c122a60598460066d456a23788f750d21800c', 'Demo3', 'Demo3', 1, 0, 'demo3@demo3', NULL, -1),
(6, 'demo4', 'f7eaf7647884430dcf73849fc512b0ee2b55d5ebe83a4d8f9b1779d4722fd575', 'Demo4', 'Demo4', 1, 0, 'demo4@demo4', NULL, -1),
(7, 'demo5', 'f2354c846c530a498890fa5f379c2323171c7dace1bc7fef1ced09c195e08677', 'Demo5', 'Demo5', 1, 0, 'demo5@demo5', NULL, -1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `resetrequests`
--
ALTER TABLE `resetrequests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tans`
--
ALTER TABLE `tans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `resetrequests`
--
ALTER TABLE `resetrequests`
  ADD CONSTRAINT `resetrequests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tans`
--
ALTER TABLE `tans`
  ADD CONSTRAINT `tans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
